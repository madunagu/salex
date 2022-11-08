<?php

namespace Salex\Warehouse\Models;

use Illuminate\Database\Eloquent\Model;
use Salex\Warehouse\Contracts\Cabinet as CabinetContract;

class Cabinet extends Model implements CabinetContract
{
    protected $fillable = [];
}