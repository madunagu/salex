<?php

namespace Salex\MarketPlace\Repositories;

use Webkul\Core\Eloquent\Repository;

class StoreReviewRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model(): string
    {
        return 'Salex\Marketplace\Contracts\StoreReview';
    }

    /**
     * Retrieve review for customerId
     *
     * @return \Illuminate\Support\Collection
     */
    public function getStoreReview($id)
    {
        $reviews = $this->model
            ->where(['store_id' => $id])
            ->paginate(5);

        return $reviews;
    }
}
