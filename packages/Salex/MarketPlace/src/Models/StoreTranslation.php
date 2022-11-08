<?php

namespace Salex\MarketPlace\Models;

use Illuminate\Database\Eloquent\Model;
use Salex\MarketPlace\Contracts\StoreTranslation as StoreTranslationContract;

class StoreTranslation extends Model implements StoreTranslationContract
{
    public $timestamps = false;

    protected $fillable = ['name', 'address', 'description', 'return_policy', 'shipping_policy', 'meta_title', 'meta_description', 'meta_keywords'];

}