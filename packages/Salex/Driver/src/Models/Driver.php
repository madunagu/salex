<?php

namespace Salex\Driver\Models;

use Illuminate\Database\Eloquent\Model;
use Salex\Driver\Contracts\Driver as DriverContract;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject as ContractsJWTSubject;
use Ramsey\Uuid\Uuid;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Storage;
use Webkul\Customer\Notifications\CustomerResetPassword;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Driver extends Authenticatable implements DriverContract, ContractsJWTSubject
{
    use HasApiTokens, HasFactory, Notifiable;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'drivers';
    protected $guarded = ['id'];

    protected $fillable = ['first_name', 'last_name', 'address', 'identity_number', 'email', 'phone', 'avatar', 'status', 'cnic', 'password'];

    protected $hidden = [
        'password'
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->identity_number = Uuid::uuid4()->toString();
        });
    }

    public function tasks()
    {
        return $this->hasMany('App\Order', 'driver_id');
    }

    public function activate()
    {
        $this->status = true;
        $this->save();
    }
    public function inactivate()
    {
        $this->status = false;
        $this->save();
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
    public function getJWTCustomClaims()
    {
        return [];
    }

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
        if (!$this->image) {
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
}
