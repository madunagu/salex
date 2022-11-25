<?php

namespace Salex\MarketPlace\Repositories;

use Illuminate\Support\Facades\Storage;
use Webkul\Core\Eloquent\Repository;

class StoreImageRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    function model()
    {
        return 'Salex\MarketPlace\Contracts\StoreImage';
    }

    /**
     * @param array $data
     * @param mixed $store
     * @return mixed
     */
    public function uploadImages($data, $store)
    {
        $previousImageIds = $store->images()->pluck('id');

        if (isset($data['images'])) {
            $savedImageIds = array_keys($data['images']);
            $oldImages = array_diff($previousImageIds->toArray(), $savedImageIds);

            foreach ($data['images'] as $imageId => $image) {
                $file = 'images.' . $imageId;
                $dir = 'store/' . $store->id;

                if (str_contains($imageId, 'image_')) {
                    if (request()->hasFile($file)) {
                        $lastImage = $this->create([
                            'path' => request()->file($file)->store($dir),
                            'store_id' => $store->id
                        ]);
                        $store->image = $lastImage->path;
                    }
                } else {
                    if (is_numeric($index = $previousImageIds->search($imageId))) {
                        $previousImageIds->forget($index);
                    }

                    if (request()->hasFile($file)) {
                        if ($imageModel = $this->find($imageId)) {
                            Storage::delete($imageModel->path);
                        }

                        $this->update([
                            'path' => request()->file($file)->store($dir)
                        ], $imageId);
                    }
                }
            }
            foreach ($oldImages as $imageId) {
                if ($imageModel = $this->find($imageId)) {
                    Storage::delete($imageModel->path);

                    $this->delete($imageId);
                }
            }

            $store->updateImage();
        }
    }
}
