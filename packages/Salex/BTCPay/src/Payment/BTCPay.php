<?php

namespace Salex\BTCPay\Payment;

use Webkul\Payment\Payment\Payment;

class BTCPay extends Payment
{
    /**
     * Payment method code
     *
     * @var string
     */
    protected $code  = 'btcpay';

    public function getRedirectUrl()
    {
        
    }
}