@php
if(empty($category)){

$popularCategories = app('Webkul\Category\Repositories\CategoryRepository')->getVisibleCategoryTree(1)->take(6);
$serviceCategories = app('Webkul\Category\Repositories\CategoryRepository')->getVisibleCategoryTree(2)->take(6);


$categories = $popularCategories->pluck('url_path');
$services = $serviceCategories->pluck('url_path');

}
@endphp

<popular-categories heading="{{ __('succinct::app.home.popular-product-categories') }}" :categories="{{ json_encode($categories) }}">
</popular-categories>

<popular-categories heading="{{ __('succinct::app.home.popular-service-categories') }}" :categories="{{ json_encode($services) }}">
</popular-categories>