<?php

namespace Salex\Driver\Repositories;

use Webkul\Core\Eloquent\Repository;
use Salex\Driver\Contracts\Vehicle;

class VehicleRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    function model()
    {
        return Vehicle::class;
    }
}