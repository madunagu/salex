<?php

namespace Salex\MarketPlace\Repositories;

use Illuminate\Container\Container as App;
use DB;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Storage;
use Webkul\Core\Eloquent\Repository;


class StoreCategoryRepository extends Repository{

    public function __construct(App $app)
    {
        parent::__construct($app);
    }

    function model()
    {
        return 'Salex\MarketPlace\Contracts\StoreCategory';
    }

    public function create(array $data){

        if(isset($data['locale']) && $data['locale'] == 'all'){

            $model = app()->make($this->model());

            foreach (core()->getAllLocales() as $locale){

                foreach ($model->translatedAttributes as $attribute){

                    if (isset($data[$attribute])){

                        $data[$locale->code][$attribute] = $data[$attribute];

                    }

                }

            }

        }

        $storeCategory = $this->model->create($data);

        return $storeCategory;

    }

    /**
     * @param array $data
     * @param $id
     * @param string $attribute
     * @return mixed
     */
    public function update(array $data, $id, $attribute = "id")
    {
        $category = $this->find($id);

        Event::fire('marketplace.category.update.before', $id);

        $category->update($data);

        $this->uploadImages($data, $category);

        Event::fire('marketplace.category.update.after', $id);

        return $category;
    }


    /**
     * @param array $data
     * @param mixed $category
     * @return void
     */
    public function uploadImages($data, $category, $type = "image")
    {
        if (isset($data[$type])) {
            $request = request();

            foreach ($data[$type] as $imageId => $image) {
                $file = $type . '.' . $imageId;
                $dir = 'store-category/' . $category->id;

                if ($request->hasFile($file)) {
                    if ($category->{$type}) {
                        Storage::delete($category->{$type});
                    }

                    $category->{$type} = $request->file($file)->store($dir);
                    $category->save();
                }
            }
        } else {
            if ($category->{$type}) {
                Storage::delete($category->{$type});
            }

            $category->{$type} = null;
            $category->save();
        }
    }

}