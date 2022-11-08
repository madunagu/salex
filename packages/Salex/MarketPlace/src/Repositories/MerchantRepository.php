<?php

namespace Salex\MarketPlace\Repositories;

use Illuminate\Container\Container as App;
use DB;
use Illuminate\Support\Facades\Event;
use Webkul\Core\Eloquent\Repository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Storage;
use Salex\MarketPlace\Contracts\Store;


class MerchantRepository extends Repository
{
    public function __construct(App $app)
    {
        parent::__construct($app);
    }

    public function model()
    {
        return 'Salex\MarketPlace\Contracts\Merchant';
    }

    /**
     * Upload customer's images.
     *
     * @param  array  $data
     * @param  \Webkul\Customer\Models\Customer  $customer
     * @param  string $type
     * @return void
     */
    public function uploadImages($data, $merchant, $type = 'image')
    {
        if (isset($data[$type])) {
            $request = request();

            foreach ($data[$type] as $imageId => $image) {
                $file = $type . '.' . $imageId;
                $dir = 'merchant/' . $merchant->id;

                if ($request->hasFile($file)) {
                    if ($merchant->{$type}) {
                        Storage::delete($merchant->{$type});
                    }

                    $merchant->{$type} = $request->file($file)->store($dir);
                    $merchant->save();
                }
            }
        } else {
            if ($merchant->{$type}) {
                Storage::delete($merchant->{$type});
            }

            $merchant->{$type} = null;
            $merchant->save();
        }
    }
}