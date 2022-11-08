<?php

namespace Salex\Driver\Http\Controllers\Shop;

use Hash;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Mail;
use Salex\Driver\Repositories\DriverRepository;
use Salex\Driver\Repositories\VehicleRepository;
use Webkul\Core\Repositories\SubscribersListRepository;
use Salex\Driver\Http\Requests\DriverProfileRequest;
use Salex\MarketPlace\Repositories\MerchantRepository;
use Webkul\Product\Repositories\ProductReviewRepository;
use Webkul\Shop\Mail\SubscriptionEmail;

class DriverController extends Controller
{
    /**
     * Contains route related configuration.
     *
     * @var array
     */
    protected $_config;

    /**
     * Create a new controller instance.
     *
     * @param  \Webkul\Customer\Repositories\CustomerRepository  $customerRepository
     * @param  \Webkul\Product\Repositories\ProductReviewRepository  $productReviewRepository
     * @param  \Webkul\Core\Repositories\SubscribersListRepository  $subscriptionRepository
     * @return void
     */
    public function __construct(
        protected DriverRepository $driverRepository,
        protected VehicleRepository $vehicleRepository,
    )
    {
        $this->_config = request('_config');
    }

    /**
     * Taking the customer to profile details page.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $driver = $this->driverRepository->find(auth()->guard('driver')->user()->id);

        return view($this->_config['view'], compact('driver'));
    }

    /**
     * For loading the edit form page.
     *
     * @return \Illuminate\View\View
     */
    public function edit()
    {
        $driver = $this->driverRepository->find(auth()->guard('driver')->user()->id);

        return view($this->_config['view'], compact('driver'));
    }

    /**
     * Edit function for editing customer profile.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(DriverProfileRequest $driverProfileRequest)
    {
        $isPasswordChanged = false;

        $data = $driverProfileRequest->validated();

        if (isset($data['date_of_birth']) && $data['date_of_birth'] == '') {
            unset($data['date_of_birth']);
        }


        Event::dispatch('merchant.update.before');

        if ($driver = $this->driverRepository->update($data, auth()->guard('driver')->user()->id)) {
            if ($isPasswordChanged) {
                Event::dispatch('user.admin.update-password', $driver);
            }

            Event::dispatch('driver.update.after', $driver);


            $this->driverRepository->uploadImages($data, $driver);

            session()->flash('success', trans('shop::app.customer.account.profile.edit-success'));

            return redirect()->route($this->_config['redirect']);
        }

        session()->flash('success', trans('shop::app.customer.account.profile.edit-fail'));

        return redirect()->back($this->_config['redirect']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $id = auth()->guard('driver')->user()->id;

        $data = request()->all();

        $driverRepository = $this->driverRepository->findorFail($id);

        try {
            if (Hash::check($data['password'], $driverRepository->password)) {
                // $orders = $driverRepository->all_products->whereIn('status', ['pending', 'processing'])->first();

                // if ($orders) {
                //     session()->flash('error', trans('admin::app.response.order-pending', ['name' => 'Merchant']));

                //     return redirect()->route($this->_config['redirect']);
                // } else {
                //     $this->merchantRepository->delete($id);

                //     session()->flash('success', trans('admin::app.response.delete-success', ['name' => 'Merchant']));

                //     return redirect()->route('merchant.session.index');
                // }
            } else {
                session()->flash('error', trans('shop::app.customer.account.address.delete.wrong-password'));

                return redirect()->back();
            }
        } catch (\Exception $e) {
            session()->flash('error', trans('admin::app.response.delete-failed', ['name' => 'Driver']));

            return redirect()->route($this->_config['redirect']);
        }
    }

    /**
     * Load the view for the customer account panel, showing approved reviews.
     *
     * @return \Illuminate\View\View
     */
    public function reviews()
    {
        $reviews = $this->productReviewRepository->getCustomerReview();

        return view($this->_config['view'], compact('reviews'));
    }
}
