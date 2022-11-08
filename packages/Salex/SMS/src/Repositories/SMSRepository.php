<?php

namespace Salex\SMS\Repositories;

use Webkul\Core\Eloquent\Repository;
use Salex\SMS\Contracts\SMS;

class SMSRepository extends Repository
{
    /**
    * Specify Model class name
    *
    * @return mixed
    */
    function model()
    {
        return SMS::class;
    }

    function lastSpecific($event_key,$to){
        return $this->model()::where('event_key',$event_key)->where('to',$to)->first();
    }
}