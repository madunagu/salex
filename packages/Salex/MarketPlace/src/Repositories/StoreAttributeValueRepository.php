<?php

namespace Salex\MarkeetPlace\Repositories;

use Illuminate\Container\Container as App;
use Webkul\Attribute\Repositories\AttributeRepository;
use Webkul\Core\Eloquent\Repository;
use Salex\MarketPlace\Models\StoreAttributeValue;



class StoreAttributeValueRepository extends Repository{

    /**
     * AttributeRepository object
     *
     * @var array
     */
    protected $attribute;

    /**
     * Create a new controller instance.
     *
     * @param  Webkul\Attribute\Repositories\AttributeRepository $attribute
     * @return void
     */
    public function __construct(AttributeRepository $attribute, App $app)
    {
        $this->attribute = $attribute;

        parent::__construct($app);
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function create(array $data)
    {
        if (isset($data['attribute_id'])) {
            $attribute = $this->attribute->find($data['attribute_id']);
        } else {
            $attribute = $this->attribute->findOneByField('code', $data['attribute_code']);
        }

        if (! $attribute)
            return;

        $data[StoreAttributeValue::$attributeTypeFields[$attribute->type]] = $data['value'];

        return $this->model->create($data);
    }

    public function model()
    {
        return 'Salex\MarketPlace\Contracts\StoreAttributeValue';
    }

    /**
     * @param string $column
     * @param int    $attributeId
     * @param int    $productId
     * @param string $value
     * @return boolean
     */
    public function isValueUnique($productId, $attributeId, $column, $value)
    {
        $result = $this->resetScope()->model->where($column, $value)->where('attribute_id', '=', $attributeId)->where('product_id', '!=', $productId)->get();

        return $result->count() ? false : true;
    }

}