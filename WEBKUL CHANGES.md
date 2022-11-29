THESE ARE THE CHANGES MADE ON THE BAGISTO PACKAGES, FILE NAME AND THEN THE CHANGES SUBSEQUENTLY THE REASONS FOR THE CHANGE

Webkul\Customer\Http\Requests\CustomerRegistrationRequest.php;

== Added a line(commented out) to validate the phone number as required
```php
private $rules = [
== // 'phone' => 'string|required',
]
```
Webkul\Product\Models\Product.php;

== Added a vendor ID to products model to validate the phone number as required
``` php

protected $fillable = [
++    'vendor_id',
]
```

Webkul\Customer\Http\Requests\CustomerProfileRequest.php;
== Commented out gender from request params because it was used for merchant profile also
```php
return [
--    // 'gender'   => 'required|in:Other,Male,Female',
]
```
Webkul\Customer\Http\Requests\CustomerAddressRequest;
== Commented out Vat Id from AddressRequest required Parameters
```php
return [
-- 'vat_id'       => [new VatIdRule()],
]
```
Webkul\Core\Models\Address.php;
== Added Longitude and lattitude to address model
```php
protected $fillable = [
++        'latitude',
++        'longitude',
]
```
Webkul\Customer\Http\Controllers\AddressController.php;
== Added a geocoding block to add lattitude and logitude to the address when creating it

```php

        $geocoder = app('geocoder');

        $addressString = $data['address1'] . ' ' . $data['city'] . ' ' . $data['state'] . ' ' . $data['country'];
        Log::info('ADDRESS: '. $addressString);
        // geocode the address and get the first result
        $result = $geocoder->geocode($addressString)->get()->first();

        // if a result couldn't be found, redirect to the home page with a result message flashed to the session
        if (!$result) {
            return redirect()->back()->with('error', 'bad address not geocodable');
        }

        // get the coordinates of the geocoding result
        $coordinates = $result->getCoordinates();

        // get the latitude of the coordinates
        $lat = $coordinates->getLatitude();

        // get the longitude of the coordinates
        $lng = $coordinates->getLongitude();

        $data['latitude'] = $lat;
        $data['longitude'] = $lng;
        Log::info('DATA: ',compact('data'));

```

Webkul\Product\Repositories\ProductRepository;
== Added vendor_id to search method from products get all search 
```php

            if (! empty($params['vendor_id'])) {
                $qb->where('products.vendor_id', $params['vendor_id']);
            }
```