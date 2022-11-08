<?php

namespace Salex\Binance\Payment;

use BinanceClient;
use Webkul\Payment\Payment\Payment;

class Binance extends Payment
{
    /**
     * Binance Pay Key.
     *
     * @var string
     */
    protected $binanceKey;

    /**
     * Client secret.
     *
     * @var string
     */
    protected $binanceSecret;

    /**
     * Payment method code
     *
     * @var string
     */
    protected $code  = 'binance';

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->initialize();
    }


    /**
     * Initialize properties.
     *
     * @return void
     */
    protected function initialize()
    {
        $this->binanceKey = $this->getConfigData('binance_key') ?: '';

        $this->binanceSecret = $this->getConfigData('binance_secret') ?: '';
    }

    /**
     * Get capture id.
     *
     * @param  string  $orderId
     * @return string
     */
    public function getCaptureId($orderId)
    {
        $paypalOrderDetails = $this->getOrder($orderId);
        return $paypalOrderDetails->result->purchase_units[0]->payments->captures[0]->id;
    }

    public function client()
    {
        return new BinanceClient();
    }


    /**
     * Create order for approval of client.
     *
     * @param  array  $body
     * @return HttpResponse
     */
    public function createOrder($body)
    {
        return $this->client()->createOrder($body);
    }

    /**
     * Capture order after approval.
     *
     * @param  string  $orderId
     * @return HttpResponse
     */
    public function captureOrder($orderId)
    {
        return $this->client()->captureOrder($orderId);
    }

    /**
     * Get order details.
     *
     * @param  string  $orderId
     * @return HttpResponse
     */
    public function getOrder($orderId)
    {
        return $this->client()->getOrder($orderId);
    }

    public function getRedirectUrl()
    {
    }


    /**
     * Add order item fields
     *
     * @param  array  $fields
     * @param  int  $i
     * @return void
     */
    protected function addLineItemsFields(&$fields, $i = 1)
    {
        $cartItems = $this->getCartItems();

        foreach ($cartItems as $item) {
            foreach ($this->itemFieldsFormat as $modelField => $paypalField) {
                $fields[sprintf($paypalField, $i)] = $item->{$modelField};
            }

            $i++;
        }
    }

    /**
     * Refund order.
     *
     * @return HttpResponse
     */
    public function refundOrder($captureId, $body = [])
    {
        return $this->client()->refundOrder($captureId, $body);
    }



    /**
     * Checks if line items enabled or not
     *
     * @return bool
     */
    public function getIsLineItemsEnabled()
    {
        return true;
    }

    /**
     * Format a currency value according to paypal's api constraints
     * 
     * @param float|int $long
     * @return float
     */
    public function formatCurrencyValue($number): float
    {
        return round((float) $number, 2);
    }
}
