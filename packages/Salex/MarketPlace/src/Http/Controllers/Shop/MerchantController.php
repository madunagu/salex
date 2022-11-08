<?php

namespace Salex\MarketPlace\Http\Controllers\Shop;

use Hash;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Mail;
use Webkul\Core\Repositories\SubscribersListRepository;
use Webkul\Customer\Http\Requests\CustomerProfileRequest;
use Salex\MarketPlace\Repositories\MerchantRepository;
use Webkul\Product\Repositories\ProductReviewRepository;
use Webkul\Shop\Mail\SubscriptionEmail;

class MerchantController extends Controller
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
        protected MerchantRepository $merchantRepository,
        protected ProductReviewRepository $productReviewRepository,
        protected SubscribersListRepository $subscriptionRepository
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
        $merchant = $this->merchantRepository->find(auth()->guard('merchant')->user()->id);

        return view($this->_config['view'], compact('merchant'));
    }

    /**
     * For loading the edit form page.
     *
     * @return \Illuminate\View\View
     */
    public function edit()
    {
        $merchant = $this->merchantRepository->find(auth()->guard('merchant')->user()->id);

        return view($this->_config['view'], compact('merchant'));
    }

    /**
     * Edit function for editing customer profile.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(CustomerProfileRequest $customerProfileRequest)
    {
        $isPasswordChanged = false;

        $data = $customerProfileRequest->validated();

        if (isset($data['date_of_birth']) && $data['date_of_birth'] == '') {
            unset($data['date_of_birth']);
        }

        $data['subscribed_to_news_letter'] = isset($data['subscribed_to_news_letter']) ? 1 : 0;

        if (isset($data['oldpassword'])) {
            if ($data['oldpassword'] != '' || $data['oldpassword'] != null) {
                if (Hash::check($data['oldpassword'], auth()->guard('merchant')->user()->password)) {
                    $isPasswordChanged = true;

                    $data['password'] = bcrypt($data['password']);
                } else {
                    session()->flash('warning', trans('shop::app.customer.account.profile.unmatch'));

                    return redirect()->back();
                }
            } else {
                unset($data['password']);
            }
        }

        Event::dispatch('merchant.update.before');

        if ($merchant = $this->merchantRepository->update($data, auth()->guard('merchant')->user()->id)) {
            if ($isPasswordChanged) {
                Event::dispatch('user.admin.update-password', $merchant);
            }

            Event::dispatch('merchant.update.after', $merchant);


            $this->merchantRepository->uploadImages($data, $merchant);

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
        $id = auth()->guard('merchant')->user()->id;

        $data = request()->all();

        $merchantRepository = $this->merchantRepository->findorFail($id);

        try {
            if (Hash::check($data['password'], $merchantRepository->password)) {
                $orders = $merchantRepository->all_products->whereIn('status', ['pending', 'processing'])->first();

                if ($orders) {
                    session()->flash('error', trans('admin::app.response.order-pending', ['name' => 'Merchant']));

                    return redirect()->route($this->_config['redirect']);
                } else {
                    $this->merchantRepository->delete($id);

                    session()->flash('success', trans('admin::app.response.delete-success', ['name' => 'Merchant']));

                    return redirect()->route('merchant.session.index');
                }
            } else {
                session()->flash('error', trans('shop::app.customer.account.address.delete.wrong-password'));

                return redirect()->back();
            }
        } catch (\Exception $e) {
            session()->flash('error', trans('admin::app.response.delete-failed', ['name' => 'Merchant']));

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
