<?php

namespace Salex\Verifone\Payment;

use Webkul\Payment\Payment\Payment;

class Verifone extends Payment
{
    /**
     * Payment method code
     *
     * @var string
     */
    protected $code  = 'verifone';

    public function getRedirectUrl()
    {
        
    }
}