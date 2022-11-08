<?php

namespace Salex\Driver\Models;

use Illuminate\Database\Eloquent\Model;
use Salex\Driver\Contracts\DriverTask as DriverTaskContract;

class DriverTask extends Model implements DriverTaskContract
{
    protected $fillable = [];
}