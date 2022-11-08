<?php

namespace Salex\Driver\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\Factory;
use Webkul\Core\Models\Address;
use Webkul\Customer\Models\CustomerAddress as WebkulAddress;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Webkul\Customer\Database\Factories\CustomerAddressFactory;
use Webkul\Customer\Contracts\CustomerAddress as CustomerAddressContract;

class CustomerAddress extends WebkulAddress implements CustomerAddressContract
{
    use HasFactory;

    public const ADDRESS_TYPE = 'customer';

    /**
     * @var array default values
     */
    protected $attributes = [
        'address_type' => self::ADDRESS_TYPE,
    ];

        /**
     * Fillable.
     *
     * @var array
     */
    protected $fillable = [
        'address_type',
        'customer_id',
        'cart_id',
        'order_id',
        'first_name',
        'last_name',
        'gender',
        'company_name',
        'address1',
        'address2',
        'postcode',
        'city',
        'state',
        'country',
        'email',
        'phone',
        'default_address',
        'vat_id',
        'additional',
        'latitude',
        'longitude',
    ];
    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function boot(): void
    {
        static::addGlobalScope('address_type', static function (Builder $builder) {
            $builder->where('address_type', self::ADDRESS_TYPE);
        });

        parent::boot();
    }

    /**
     * Create a new factory instance for the model
     *
     * @return Factory
     */
    protected static function newFactory(): Factory
    {
        return CustomerAddressFactory::new();
    }
}
