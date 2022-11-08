<?php

namespace Salex\MarketPlace\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;
use Salex\MarketPlace\Contracts\Merchant as MerchantContract;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Storage;
use Webkul\Customer\Models\CustomerAddressProxy;
use Webkul\Customer\Http\Requests\CustomerForgotPasswordRequest;
use Webkul\Product\Models\ProductProxy;
use Webkul\Sales\Models\OrderItemProxy;

class Merchant extends Authenticatable implements MerchantContract, JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable;

    /* The table associated with the model.
    *
    * @var string
    */
   protected $table = 'merchants';


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'sex',
        'date_of_birth',
        'email',
        'phone',
        'password',
        'api_token',
        'token',
        // 'customer_group_id',
        // 'subscribed_to_news_letter',
        'status',
        'is_verified',
        'is_suspended',
        // 'notes',
    ];

        /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'api_token',
        'remember_token',
    ];


     /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token): void
    {
        $this->notify(new CustomerResetPassword($token));
    }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims(): array
    {
        return [];
    }

    /**
     * Get image url for the customer profile.
     *
     * @return string|null
     */
    public function getImageUrlAttribute()
    {
        return $this->image_url();
    }

    /**
     * Get the customer full name.
     *
     * @return string
     */
    public function getNameAttribute(): string
    {
        return ucfirst($this->first_name) . ' ' . ucfirst($this->last_name);
    }

    /**
     * Get image url for the customer image.
     *
     * @return string|null
     */
    public function image_url()
    {
        if (! $this->image) {
            return;
        }

        return Storage::url($this->image);
    }

    /**
     * Is email exists or not.
     *
     * @param  string  $email
     * @return bool
     */
    public function emailExists($email): bool
    {
        $results = $this->where('email', $email);

        if ($results->count() === 0) {
            return false;
        }

        return true;
    }


    /**
     * Get the customer address that owns the customer.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function addresses()
    {
        return $this->hasMany(CustomerAddressProxy::modelClass(), 'merchant_id');
    }

        /**
     * Get all orders of a customer.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function all_products()
    {
        return $this->hasMany(ProductProxy::modelClass(), 'vendor_id','store_id');
    }

    /**
     * Get default customer address that owns the customer.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function default_address()
    {
        return $this->hasOne(CustomerAddressProxy::modelClass(), 'merchant_id')
            ->where('default_address', 1);
    }


}
