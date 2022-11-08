<?php

namespace Salex\MarketPlace\Models;

use Illuminate\Database\Eloquent\Model;
use Salex\MarketPlace\Contracts\Store as StoreContract;

use Illuminate\Support\Facades\Storage;
use Webkul\Core\Eloquent\TranslatableModel;

class Store extends TranslatableModel implements StoreContract
{

    public $translatedAttributes = ['owner_id','name', 'address', 'description', 'return_policy', 'shipping_policy', 'meta_title', 'meta_description', 'meta_keywords'];

    protected $fillable = ['url','tax_number', 'featured', 'state_id', 'is_physical', 'category_id', 'phone', 'geolocation', 'is_visible', 'facebook', 'twitter', 'instagram', 'telegram'];

    protected $with = ['translations'];

    public function sellers()
    {
        return $this->hasMany(Seller::class);
    }

    public function activate()
    {

        $this->status = 1;
    }

    public function inactivate()
    {

        $this->status = 0;
    }

    public function isActive()
    {

        return $this->status;
    }

    public function path()
    {

        return '/' . $this->id;
    }

    /**
     * Get image url for the store image.
     */
    public function image_url()
    {
        if (!$this->image)
            return;

        return Storage::url($this->image);
    }

    /**
     * Get image url for the store image.
     */
    public function getImageUrlAttribute()
    {
        return $this->image_url();
    }

    //    public function getRouteKeyName()
    //    {
    ////        return 'url';
    //    }
}
