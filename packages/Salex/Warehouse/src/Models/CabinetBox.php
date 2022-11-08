<?php

namespace Salex\Warehouse\Models;

use Illuminate\Database\Eloquent\Model;
use Salex\Warehouse\Contracts\CabinetBox as CabinetBoxContract;

class CabinetBox extends Model implements CabinetBoxContract
{
    protected $fillable = [];
}