@php
if(empty($category)){
$category = [ 'a-aspernatur-dolorum-et-autem','nihil-quidem-ab-nesciunt-esse-et-ut-optio','odit-aut-quaerat-maxime-quisquam-praesentium-explicabo','odio-vel-et-earum-vitae',
'minima-velit-unde-inventore-possimus-consequatur-et',
'dignissimos-aut-delectus-amet-molestias',
];

$services = [ 'a-aspernatur-dolorum-et-autem','nihil-quidem-ab-nesciunt-esse-et-ut-optio','odit-aut-quaerat-maxime-quisquam-praesentium-explicabo','odio-vel-et-earum-vitae',
'minima-velit-unde-inventore-possimus-consequatur-et',
'dignissimos-aut-delectus-amet-molestias',
];

$categories = app('Webkul\Velocity\Repositories\ContentRepository')->getAllContents();
$services = array_column($categories, 'page_link');

}
@endphp

<popular-categories heading="{{ __('succinct::app.home.popular-product-categories') }}" :categories="{{ json_encode($category) }}">
</popular-categories>

<popular-categories heading="{{ __('succinct::app.home.popular-service-categories') }}" :categories="{{ json_encode($services) }}">
</popular-categories>