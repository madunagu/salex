<?php

namespace Salex\Driver\Models;

use Illuminate\Database\Eloquent\Model;
use Salex\Driver\Contracts\Vehicle as VehicleContract;

class Vehicle extends Model implements VehicleContract
{
    protected $fillable = ['type', 'color', 'plate_no', 'vin_no', 'year', 'model', 'driver_id', 'owned_by_driver'];
}
