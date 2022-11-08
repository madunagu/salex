<?php

namespace Salex\Warehouse\Models;

use Illuminate\Database\Eloquent\Model;
use Salex\Warehouse\Contracts\PackageCabinet as PackageCabinetContract;

class PackageCabinet extends Model implements PackageCabinetContract
{
    protected $fillable = [];
}