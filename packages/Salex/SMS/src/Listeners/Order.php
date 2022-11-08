<?php

namespace Salex\SMS\Listeners;

use Exception;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

use Webkul\Sales\Repositories\OrderRepository;
use Webkul\Core\Repositories\CoreConfigRepository;
use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;


use Illuminate\Support\Facades\Log;
use Salex\SMS\Repositories\SMSRepository;
use Salex\SMS\Traits\Sender;

class Order implements ShouldQueue
{
    use Sender, InteractsWithQueue;

    // /**
    //  * Create the event listener.
    //  *
    //  * @return void
    //  */
    // public function __construct(
    //     protected OrderRepository $orderRepository,
    //     protected SMSRepository $sMSRepository,
    //     protected CoreConfigRepository $coreConfigRepository
    // ) {
    //     // parent::__construct();
    // }

    static $configShouldSendKey = 'sms.general.notifications.new-order';
    /**
     * Handle the event.
     *
     * @param  object  $order
     * @return void
     */
    public function handle($order)
    {
        $recipient = $order->customer;
        $text  = __('sms::app.messages.order-recieved', ['first_name' => $order->customer_first_name, 'status' => $order->status, 'order_id' => $order->id]);
        $event_key = 'order.recieved';
        $this->sendSMS($event_key, $recipient, $text);
    }

    /**
     * Prepares order's invoice data for creation.
     *
     * @return array
     */
    protected function prepareInvoiceData($order)
    {
        $invoiceData = ['order_id' => $order->id];

        foreach ($order->items as $item) {
            $invoiceData['invoice']['items'][$item->id] = $item->qty_to_invoice;
        }

        return $invoiceData;
    }
}
