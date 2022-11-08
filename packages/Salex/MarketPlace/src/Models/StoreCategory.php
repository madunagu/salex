<?php

namespace Salex\MarketPlace\Models;

use Illuminate\Database\Eloquent\Model;
use Salex\MarketPlace\Contracts\StoreCategory as StoreCategoryContract;
use Webkul\Core\Eloquent\TranslatableModel;

class StoreCategory extends TranslatableModel implements StoreCategoryContract
{
    public $translatedAttributes = ['name', 'description', 'meta_title', 'meta_keywords', 'meta_description'];

    protected $fillable = ['code'];

    public $timestamps = false;
}