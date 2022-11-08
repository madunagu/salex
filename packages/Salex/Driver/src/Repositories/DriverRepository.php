<?php

namespace Salex\Driver\Repositories;

use Webkul\Core\Eloquent\Repository;
use Salex\Driver\Contracts\Driver;
use Illuminate\Support\Facades\Storage;

class DriverRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    function model()
    {
        return Driver::class;
    }

    /**
     * Upload customer's images.
     *
     * @param  array  $data
     * @param  \Webkul\Customer\Models\Customer  $customer
     * @param  string $type
     * @return void
     */
    public function uploadImages($data, $driver, $type = 'image')
    {
        if (isset($data[$type])) {
            $request = request();

            foreach ($data[$type] as $imageId => $image) {
                $file = $type . '.' . $imageId;
                $dir = 'driver/' . $driver->id;

                if ($request->hasFile($file)) {
                    if ($driver->{$type}) {
                        Storage::delete($driver->{$type});
                    }

                    $driver->{$type} = $request->file($file)->store($dir);
                    $driver->save();
                }
            }
        } else {
            if ($driver->{$type}) {
                Storage::delete($driver->{$type});
            }

            $driver->{$type} = null;
            $driver->save();
        }
    }
}
