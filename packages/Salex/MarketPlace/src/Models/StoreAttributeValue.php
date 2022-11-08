<?php

namespace Salex\MarketPlace\Models;

use Illuminate\Database\Eloquent\Model;
use Salex\MarketPlace\Contracts\StoreAttributeValue as StoreAttributeValueContract;
use Webkul\Core\Eloquent\TranslatableModel;

class StoreAttributeValue extends TranslatableModel implements StoreAttributeValueContract
{
    public $timestamps = false;

}
