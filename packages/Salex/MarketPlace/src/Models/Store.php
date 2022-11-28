<?php

namespace Salex\MarketPlace\Models;

use Illuminate\Database\Eloquent\Model;
use Salex\MarketPlace\Contracts\Store as StoreContract;

use Illuminate\Support\Facades\Storage;
use Webkul\Core\Eloquent\TranslatableModel;

class Store extends TranslatableModel implements StoreContract
{

    public $translatedAttributes = ['owner_id', 'name', 'address', 'description', 'return_policy', 'shipping_policy', 'meta_title', 'meta_description', 'meta_keywords'];

    protected $fillable = ['url', 'tax_number', 'featured', 'state_id', 'is_physical', 'category_id', 'phone', 'geolocation', 'is_visible', 'facebook', 'twitter', 'instagram', 'telegram'];

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
        if (!$this->images)
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


    /**
     * Get the customer address that owns the customer.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function images()
    {
        return $this->hasMany(StoreImageProxy::modelClass(), 'store_id');
    }


    public function updateImage()
    {

        $this->image = $this->images()->first()->path;
        $this->save();
    }


    /**
     * Get the product reviews that owns the product.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function reviews(): HasMany
    {
        return $this->hasMany(StoreReviewProxy::modelClass());
    }



    //    public function getRouteKeyName()
    //    {
    ////        return 'url';
    //    }
}
