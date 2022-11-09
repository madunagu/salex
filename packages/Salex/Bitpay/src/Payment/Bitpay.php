<?php

namespace Salex\Bitpay\Payment;

use Webkul\Payment\Payment\Payment;
use BitPaySDKLight\Client as BitpayClient;

class Bitpay extends Payment
{
    /**
     * Payment method code
     *
     * @var string
     */
    protected $code  = 'bitpay';
    /**
     * Return bitpay redirect URL.
     *
     * @return string
     */
    public function getRedirectUrl()
    {
        return route('bitpay.redirect');
    }

    public function getClient()
    {
        $token = "5BarRh8GzfNMVaZH8Dr19Z2dRXhw44xXqjud8R9Kdg6M";
        // $token = $this->getConfigData('token');
        $bitpay = new BitpayClient($token, \BitPaySDKLight\Env::Test);
        return $bitpay;
    }

    public function generateInvoice()
    {
        $cart = $this->getCart();

        $bitpayClient = $this->getClient();
        $amount = $this->formatCurrencyValue($cart->grand_total);
        $currency = $cart->cart_currency_code;
        $invoice = new \BitPaySDKLight\Model\Invoice\Invoice($amount, $currency);
        // $token = $this->getConfigData('token');
        $token = "5BarRh8GzfNMVaZH8Dr19Z2dRXhw44xXqjud8R9Kdg6M";
        $invoice->setToken($token);
        $invoice->setOrderId($cart->id);
        $invoice->setFullNotifications(true);
        $invoice->setExtendedNotifications(true);

        $invoice->setNotificationURL(route('bitpay.ipn'));

        $invoice->setRedirectURL(route('bitpay.success'));

        $items = $cart->items;
        $description =  '';
        foreach($cart->items as $item){

            $description.= $item->name . " Quantity: ". $item->quantity. " Price: ".$item->price;
        }
        $invoice->setItemDesc($description);

        $merchantEmail = $this->getConfigData('merchant_email');
        $invoice->setNotificationEmail("ekenemadunagu@gmail.com");

        $billingAddress = $cart->billing_address;

        $buyer = new \BitPaySDKLight\Model\Invoice\Buyer();
        $buyer->setName("$billingAddress->first_name $billingAddress->last_name");
        $buyer->setEmail($billingAddress->email);
        $buyer->setAddress1($billingAddress->address1);
        $buyer->setAddress2("");
        $buyer->setCountry($billingAddress->country);
        $buyer->setLocality($billingAddress->city);
        $buyer->setNotify(true);
        // $buyer->setPhone("+2348065708630");
        $buyer->setPostalCode($billingAddress->postcode);
        $buyer->setRegion($billingAddress->state);

        $invoice->setBuyer($buyer);

        $basicInvoice = $bitpayClient->createInvoice($invoice);
        return $basicInvoice; //->getURL();
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

    /**
     * Format phone field according to paypal's api constraints
     * 
     * Strips non-numbers characters like '+' or ' ' in 
     * inputs like "+54 11 3323 2323"
     * 
     * @param mixed $phone
     * @return string
     */
    public function formatPhone($phone): string
    {
        return preg_replace('/[^0-9]/', '', (string) $phone);
    }
}
