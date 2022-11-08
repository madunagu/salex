<?php

namespace Salex\SMS\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Salex\SMS\Traits\Sender;
use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use Exception;
use Illuminate\Support\Facades\Log;

class Shipment 
{
    use Sender;
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

    public static $configShouldSendKey = 'sms.general.notifications.new-shipment';
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
}
