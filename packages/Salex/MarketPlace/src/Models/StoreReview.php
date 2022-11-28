<?php

namespace Salex\Marketplace\Models;

use Illuminate\Database\Eloquent\Model;
use Salex\Marketplace\Contracts\StoreReview as StoreReviewContract;

class StoreReview extends Model implements StoreReviewContract
{
    protected $fillable = ['id', 'title', 'rating', 'comment', 'status', 'name', 'store_id', 'customer_id'];
}
