<?php

namespace Salex\Bitpay\Helpers;

use Salex\Bitpay\Payment\Bitpay;
use Webkul\Sales\Repositories\OrderRepository;
use Webkul\Sales\Repositories\InvoiceRepository;
use Illuminate\Support\Facades\Log;

class Ipn
{
    /**
     * IPN post data.
     *
     * @var array
     */
    protected $post;

    /**
     * Order $order
     *
     * @var \Webkul\Sales\Contracts\Order
     */
    protected $order;
    /**
     * Create a new helper instance.
     *
     * @param  \Webkul\Sales\Repositories\OrderRepository  $orderRepository
     * @param  \Webkul\Sales\Repositories\InvoiceRepository  $invoiceRepository
     * @param  \Webkul\Paypal\Payment\Standard  $paypalStandard
     * @return void
     */
    public function __construct(
        protected Bitpay $bitpay,
        protected OrderRepository $orderRepository,
        protected InvoiceRepository $invoiceRepository
    ) {
    }

    /**
     * This function process the IPN sent from paypal end.
     *
     * @param  array  $post
     * @return null|void|\Exception
     */
    public function processIpn($post)
    {
        $this->post = $post;

        if (!$this->postBack()) {
            return;
        }

        try {

            $this->getOrder();

            $this->processOrder();
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Load order via IPN invoice id.
     *
     * @return void
     */
    protected function getOrder()
    {
        if (empty($this->order)) {
            $this->order = $this->orderRepository->findOneByField(['cart_id' => $this->post['data']['orderId']]);
        }
    }

    /**
     * Process order and create invoice.
     *
     * @return void
     */
    protected function processOrder()
    {
        if ($this->post['data']['amountPaid'] != $this->order->grand_total  || $this->post['data']['amountPaid'] != $this->order->order_currency_code) {
            return;
        } else {
            $this->orderRepository->update(['status' => 'processing'], $this->order->id);

            if ($this->order->canInvoice()) {
                $invoice = $this->invoiceRepository->create($this->prepareInvoiceData());
            }
        }
    }

    /**
     * Prepares order's invoice data for creation.
     *
     * @return array
     */
    protected function prepareInvoiceData()
    {
        $invoiceData = ['order_id' => $this->order->id];

        foreach ($this->order->items as $item) {
            $invoiceData['invoice']['items'][$item->id] = $item->qty_to_invoice;
        }

        return $invoiceData;
    }

    /**
     * Post back to PayPal to check whether this request is a valid one.
     *
     * @return bool
     */
    protected function postBack()
    {
        Log::info(print_r($this->post, true));

        $invoiceId = $this->post['data']['id'];

        $bitpayClient = $this->bitpay->getClient();

        $invoice = $bitpayClient->getInvoice($invoiceId);

        $status = $invoice->getStatus();

        if ($status == 'confirmed') {
            return true;
        }

        return false;
    }
}
