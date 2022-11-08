<?php

namespace Salex\MarketPlace\Models;

use Illuminate\Database\Eloquent\Model;
use Salex\MarketPlace\Contracts\StoreCategoryTranslation as StoreCategoryTranslationContract;

class StoreCategoryTranslation extends Model implements StoreCategoryTranslationContract
{
    protected $fillable = [];
}