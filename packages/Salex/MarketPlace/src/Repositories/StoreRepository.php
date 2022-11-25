<?php

namespace Salex\MarketPlace\Repositories;

use Illuminate\Container\Container as App;
use DB;
use Illuminate\Support\Facades\Event;
use Webkul\Core\Eloquent\Repository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Storage;
use Salex\MarketPlace\Contracts\Store;


class StoreRepository extends Repository
{
    public function __construct(App $app)
    {
        parent::__construct($app);
    }

    public function model()
    {
        return 'Salex\MarketPlace\Contracts\Store';
    }

    public function create(array $data)
    {
        Event::dispatch('marketplace.store.create.before');

        if (isset($data['locale']) && $data['locale'] == 'all') {
            $model = app()->make($this->model());

            foreach (core()->getAllLocales() as $locale) {
                foreach ($model->translatedAttributes as $attribute) {
                    if (isset($data[$attribute])) {
                        $data[$locale->code][$attribute] = $data[$attribute];
                    }
                }
            }
        }

        $store = $this->model->create($data);

        Event::dispatch('marketplace.store.create.after');

        return $store;
    }

    /**
     * @param array $data
     * @param $id
     * @param string $attribute
     * @return mixed
     */
    public function update(array $data, $id, $attribute = "id")
    {
        $store = $this->find($id);

        Event::dispatch('marketplace.store.update.before', $id);

        $store->update($data);

        Event::dispatch('marketplace.store.update.after', $id);

        return $store;
    }


}
