<?php

namespace Salex\MarketPlace\Models;

use Illuminate\Database\Eloquent\Model;
use Salex\MarketPlace\Contracts\StoreImage as StoreImageContract;

class StoreImage extends Model implements StoreImageContract
{
    protected $fillable = ['path','store_id','type'];
}