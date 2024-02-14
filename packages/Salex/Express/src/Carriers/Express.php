<?php

namespace Salex\Express\Carriers;

use Config;
use Webkul\Shipping\Carriers\AbstractShipping;
use Webkul\Checkout\Models\CartShippingRate;
use Webkul\Checkout\Facades\Cart;

use Webkul\Shipping\Facades\Shipping;

class Express extends AbstractShipping
{
    /**
     * Shipping method code
     *
     * @var string
     */
    protected $code  = 'express';

    /**
     * Returns rate for shipping method
     *
     * @return CartShippingRate|false
     */
    public function calculate()
    {
        if (!$this->isAvailable()) {
            return false;
        }
        $cart = Cart::getCart();

        $cartShippingRate = new CartShippingRate;
        // Same Day shipping
        // Next day shipping
        // Free shipping

        $cartShippingRate->carrier = 'express';
        $cartShippingRate->carrier_title = $this->getConfigData('title');
        $cartShippingRate->method = 'express_express';
        $cartShippingRate->method_title = $this->getConfigData('title');
        $cartShippingRate->method_description = $this->getConfigData('description');
        $cartShippingRate->price =    100;
        $cartShippingRate->base_price = 23;

        if ($this->getConfigData('type') == 'per_unit') {
            foreach ($cart->items as $item) {
                if ($item->product->getTypeInstance()->isStockable()) {
                    $cartShippingRate->price += core()->convertPrice($this->getConfigData('default_rate')) * $item->quantity;
                    $cartShippingRate->base_price += $this->getConfigData('default_rate') * $item->quantity;
                }
            }
        } else {
            $cartShippingRate->price = core()->convertPrice($this->getConfigData('default_rate'));
            $cartShippingRate->base_price = $this->getConfigData('default_rate');
        }

        return $cartShippingRate;
    }
}
