<?php

namespace Salex\Bitpay\Payment;

use Webkul\Payment\Payment\Payment;

class Bitpay extends Payment
{
    /**
     * Payment method code
     *
     * @var string
     */
    protected $code  = 'bitpay';

    public function getRedirectUrl()
    {
        
    }
}