<?php

namespace Salex\Driver\Http\Controllers\Admin;

use Illuminate\Routing\Controller;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Salex\Driver\Repositories\DriverRepository;
use Webkul\Customer\Repositories\CustomerRepository;
use Webkul\Product\Repositories\ProductInventoryRepository;
use Webkul\Sales\Repositories\InvoiceRepository;
use Webkul\Sales\Repositories\OrderItemRepository;
use Webkul\Sales\Repositories\OrderRepository;
use Webkul\Sales\Repositories\ShipmentRepository;

class ShipmentDashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @var array
     */
    protected $_config;

    /**
     * Start date.
     *
     * @var \Illuminate\Support\Carbon
     */
    protected $startDate;

    /**
     * Last start date.
     *
     * @var \Illuminate\Support\Carbon
     */
    protected $lastStartDate;

    /**
     * End date.
     *
     * @var \Illuminate\Support\Carbon
     */
    protected $endDate;

    /**
     * Last end date.
     *
     * @var \Illuminate\Support\Carbon
     */
    protected $lastEndDate;

    /**
     * Create a new controller instance.
     *
     * @param  \Webkul\Sales\Repositories\OrderRepository  $orderRepository
     * @param  \Webkul\Sales\Repositories\OrderItemRepository  $orderItemRepository
     * @param  \Webkul\Customer\Repositories\CustomerRepository  $customerRepository
     * @param  \Webkul\Customer\Repositories\ShipmentRepository  $shipmentRepository
     * @param  \Webkul\Product\Repositories\ProductInventoryRepository  $productInventoryRepository
     * @return void
     */
    public function __construct(
        protected OrderRepository $orderRepository,
        protected ShipmentRepository $shipmentRepository,
        protected DriverRepository $driverRepository,
        protected OrderItemRepository $orderItemRepository,
        protected InvoiceRepository $invoiceRepository,
        protected CustomerRepository $customerRepository,
        protected ProductInventoryRepository $productInventoryRepository
    ) {
        $this->_config = request('_config');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $this->setStartEndDate();

        $statistics = [
            /**
             * These are the stats with percentage change.
             */
            'total_drivers'          => [
                'previous' => $previous = $this->getDriversBetweenDates($this->lastStartDate, $this->lastEndDate),
                'current'  => $current = $this->getDriversBetweenDates($this->startDate, $this->endDate),
                'progress' => $this->getPercentageChange($previous, $current),
            ],
            'total_shipments'             =>  [
                'previous' => $previous = $this->previousShipments()->count(),
                'current'  => $current = $this->currentShipments()->count(),
                'progress' => $this->getPercentageChange($previous, $current),
            ],
            'total_revenue'              =>  [
                'previous' => $previous = $this->previousOrders()->sum('shipping_amount') - $this->previousOrders()->sum('shipping_amount'),
                'current'  => $current = $this->currentOrders()->sum('shipping_amount') - $this->currentOrders()->sum('shipping_amount'),
                'progress' => $this->getPercentageChange($previous, $current),
            ],
            'avg_revenue'                =>  [
                'previous' => $previous = $this->previousOrders()->avg('shipping_amount') - $this->previousOrders()->avg('shipping_amount'),
                'current'  => $current = $this->currentOrders()->avg('shipping_amount') - $this->currentOrders()->avg('shipping_amount'),
                'progress' => $this->getPercentageChange($previous, $current),
            ],

            /**
             * These are the normal stats.
             */
            'total_unshipped_orders'    => $this->getTotalUnshippedOrders(),
            'top_shipping_methods'   => $this->getTopShippingMethods(),
            'top_shipping_drivers'     => $this->getTopShippingDrivers(),
            'customer_with_most_sales' => $this->getCustomerWithMostSales(),
            'stock_threshold'          => $this->getStockThreshold(),
        ];

        foreach (core()->getTimeInterval($this->startDate, $this->endDate) as $interval) {
            $statistics['sale_graph']['label'][] = $interval['start']->format('d M');

            $total = $this->getShipmentsBetweenDate($interval['start'], $interval['end'])->count();

            $statistics['sale_graph']['total'][] = $total;
            $statistics['sale_graph']['formated_total'][] = core()->formatBasePrice($total);
        }

        return view($this->_config['view'], compact('statistics'))->with(['startDate' => $this->startDate, 'endDate' => $this->endDate]);
    }




    /**
     * Sets start and end date.
     *
     * @return void
     */
    public function setStartEndDate()
    {
        $this->startDate = request()->get('start')
            ? Carbon::createFromTimeString(request()->get('start') . " 00:00:01")
            : Carbon::createFromTimeString(Carbon::now()->subDays(30)->format('Y-m-d') . " 00:00:01");

        $this->endDate = request()->get('end')
            ? Carbon::createFromTimeString(request()->get('end') . " 23:59:59")
            : Carbon::now();

        if ($this->endDate > Carbon::now()) {
            $this->endDate = Carbon::now();
        }

        $this->lastStartDate = clone $this->startDate;
        $this->lastEndDate = clone $this->startDate;

        $this->lastStartDate->subDays($this->startDate->diffInDays($this->endDate));
    }

    /**
     * Returns percentage difference
     *
     * @param  int  $previous
     * @param  int  $current
     * @return int
     */
    public function getPercentageChange($previous, $current)
    {
        if (!$previous) {
            return $current ? 100 : 0;
        }

        return ($current - $previous) / $previous * 100;
    }

    /**
     * Returns the list of top selling categories.
     *
     * @return \Illuminate\Support\Collection
     */
    public function getTopShippingMethods()
    {
        return $this->orderRepository->getModel()
            ->leftJoin('shipments', 'orders.id', 'shipments.order_id')
            // ->leftJoin('product_categories', 'products.id', 'product_categories.product_id')
            // ->leftJoin('categories', 'product_categories.category_id', 'categories.id')
            // ->leftJoin('category_translations', 'categories.id', 'category_translations.category_id')
            // ->where('category_translations.locale', app()->getLocale())
            ->where('orders.created_at', '>=', $this->startDate)
            ->where('orders.created_at', '<=', $this->endDate)
            // ->addSelect(DB::raw('SUM(qty_invoiced - qty_refunded) as total_qty_invoiced'))
            ->addSelect(DB::raw('COUNT(' . DB::getTablePrefix() . 'orders.id) as total_orders'))
            ->addSelect(DB::raw('COUNT(' . DB::getTablePrefix() . 'shipments.id) as total_shipments'))
            ->addSelect('orders.shipping_method', 'orders.shipping_title as shipping_title', 'orders.id')
            ->groupBy('orders.shipping_method')
            // ->havingRaw('SUM(qty_invoiced - qty_refunded) > 0')
            ->orderBy('total_orders', 'DESC')
            ->limit(5)
            ->get();
    }

    /**
     * Return stock threshold.
     *
     * @return \Illuminate\Support\Collection
     */
    public function getStockThreshold()
    {
        return $this->productInventoryRepository->getModel()
            ->leftJoin('products', 'product_inventories.product_id', 'products.id')
            ->select(DB::raw('SUM(qty) as total_qty'))
            ->addSelect('product_inventories.product_id')
            ->groupBy('product_id')
            ->orderBy('total_qty', 'ASC')
            ->limit(5)
            ->get();
    }

    /**
     * Returns top selling products.
     *
     * @return \Illuminate\Support\Collection
     */
    public function getTopShippingDrivers()
    {
        return $this->driverRepository->getModel()
            ->leftJoin('shipments', 'drivers.id', 'shipments.driver_id')
            ->select(DB::raw('SUM(shipments.total_qty) as total_qty_shipped'))
            ->addSelect('drivers.id', 'drivers.first_name', 'drivers.last_name', 'shipments.id')
            ->where('shipments.created_at', '>=', $this->startDate)
            ->where('shipments.created_at', '<=', $this->endDate)
            // ->whereNull('parent_id')
            ->groupBy('shipments.driver_id')
            ->orderBy('total_qty_shipped', 'DESC')
            ->limit(5)
            ->get();
    }

    /**
     * Returns cutomer with most sales.
     *
     * @return \Illuminate\Support\Collection
     */
    public function getCustomerWithMostSales()
    {
        $dbPrefix = DB::getTablePrefix();

        return $this->orderRepository->getModel()
            ->leftJoin('refunds', 'orders.id', 'refunds.order_id')
            ->select(DB::raw("(SUM({$dbPrefix}orders.base_grand_total) - SUM(IFNULL({$dbPrefix}refunds.base_grand_total, 0))) as total_base_grand_total"))
            ->addSelect(DB::raw("COUNT({$dbPrefix}orders.id) as total_orders"))
            ->addSelect('orders.id', 'customer_id', 'customer_email', 'customer_first_name', 'customer_last_name')
            ->where('orders.created_at', '>=', $this->startDate)
            ->where('orders.created_at', '<=', $this->endDate)
            ->where('orders.status', '<>', 'closed')
            ->where('orders.status', '<>', 'canceled')
            ->groupBy('customer_email')
            ->orderBy('total_base_grand_total', 'DESC')
            ->limit(5)
            ->get();
    }

    /**
     * Returns previous order query.
     *
     * @return Illuminate\Database\Query\Builder
     */
    private function previousOrders()
    {
        return $this->getOrdersBetweenDate($this->lastStartDate, $this->lastEndDate);
    }


    /**
     * Returns current order query.
     *
     * @return Illuminate\Database\Query\Builder
     */
    private function currentOrders()
    {
        return $this->getOrdersBetweenDate($this->startDate, $this->endDate);
    }

    /**
     * Returns previous order query.
     *
     * @return Illuminate\Database\Query\Builder
     */
    private function previousShipments()
    {
        return $this->getShipmentsBetweenDate($this->lastStartDate, $this->lastEndDate);
    }


    /**
     * Returns current order query.
     *
     * @return Illuminate\Database\Query\Builder
     */
    private function currentShipments()
    {
        return $this->getShipmentsBetweenDate($this->startDate, $this->endDate);
    }

    /**
     * Returns orders between two dates.
     *
     * @param  \Illuminate\Support\Carbon  $start
     * @param  \Illuminate\Support\Carbon  $end
     * @return Illuminate\Database\Query\Builder
     */
    private function getOrdersBetweenDate($start, $end)
    {
        return $this->orderRepository->scopeQuery(function ($query) use ($start, $end) {
            return $query->where('orders.created_at', '>=', $start)->where('orders.created_at', '<=', $end);
        });
    }


    /**
     * Returns orders between two dates.
     *
     * @param  \Illuminate\Support\Carbon  $start
     * @param  \Illuminate\Support\Carbon  $end
     * @return Illuminate\Database\Query\Builder
     */
    private function getDriversBetweenDates($start, $end)
    {
        return $this->driverRepository
            ->where('drivers.created_at', '>=', $start)
            ->where('drivers.created_at', '<=', $end)
            ->count();
    }

    /**
     * Returns orders between two dates.
     *
     * @param  \Illuminate\Support\Carbon  $start
     * @param  \Illuminate\Support\Carbon  $end
     * @return Illuminate\Database\Query\Builder
     */
    private function getShipmentsBetweenDate($start, $end)
    {
        return $this->shipmentRepository->scopeQuery(function ($query) use ($start, $end) {
            return $query->where('shipments.created_at', '>=', $start)->where('shipments.created_at', '<=', $end);
        });
    }

    /**
     * Returns customers between two dates.
     *
     * @param  \Illuminate\Support\Carbon  $start
     * @param  \Illuminate\Support\Carbon  $end
     * @return int
     */
    private function getCustomersBetweenDates($start, $end)
    {
        return $this->customerRepository
            ->where('customers.created_at', '>=', $start)
            ->where('customers.created_at', '<=', $end)
            ->count();
    }

    /**
     * Returns total pending invoices between two dates.
     *
     * @param  \Illuminate\Support\Carbon  $start
     * @param  \Illuminate\Support\Carbon  $end
     * @return string
     */
    private function getTotalUnshippedOrders()
    {
        // return $this->invoiceRepository
        //     ->where('state', 'pending')
        //     ->sum('grand_total');
        return $this->orderRepository->getModel()
            ->leftJoin('shipments', 'orders.id', 'shipments.order_id')
            ->whereNull('shipments.id')
            ->sum('orders.shipping_amount');
    }
}


// $geocoder = app('geocoder');

// // geocode the address and get the first result
// $result = $geocoder->geocode($address)->get()->first();

// // if a result couldn't be found, redirect to the home page with a result message flashed to the session
// if (! $result) {
//     return redirect(route(self::ROUTE_NAME_SHOW_HOME))->with(self::SESSION_KEY_ERROR, self::RESULT_BAD_ADDRESS);
// }

// // get the coordinates of the geocoding result
// $coordinates = $result->getCoordinates();

// // get the latitude of the coordinates
// $lat = $coordinates->getLatitude();

// // get the longitude of the coordinates
// $lng = $coordinates->getLongitude();