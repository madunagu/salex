<?php

namespace Salex\Driver\Http\Controllers\Shop;

use Cookie;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Salex\Driver\Http\Requests\DriverRegistrationRequest;
use Salex\Driver\Repositories\DriverRepository;
use Webkul\Core\Repositories\SubscribersListRepository;
use Salex\MarketPlace\Http\Requests\MerchantRegistrationRequest;
use Webkul\Customer\Mail\RegistrationEmail;
use Webkul\Customer\Mail\VerificationEmail;
use Webkul\Customer\Repositories\CustomerGroupRepository;
use Webkul\Customer\Repositories\CustomerRepository;
use Webkul\Shop\Mail\SubscriptionEmail;
use Salex\MarketPlace\Repositories\MerchantRepository;

class RegistrationController extends Controller
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
     * @param  \Webkul\Customer\Repositories\CustomerRepository  $customer
     * @param  \Webkul\Customer\Repositories\CustomerGroupRepository  $customerGroupRepository
     * @param  \Webkul\Core\Repositories\SubscribersListRepository  $subscriptionRepository
     * @return void
     */
    public function __construct(
        protected DriverRepository $driverRepository,
        protected CustomerGroupRepository $customerGroupRepository,
        protected SubscribersListRepository $subscriptionRepository
    )
    {
        $this->_config = request('_config');
    }

    /**
     * Opens up the user's sign up form.
     *
     * @return \Illuminate\View\View
     */
    public function show()
    {
        return view($this->_config['view']);
    }

    /**
     * Method to store user's sign up form data to DB.
     *
     * @param  \Webkul\Customer\Http\Requests\CustomerRegistrationRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function create(DriverRegistrationRequest $request)
    {
        $request->validated();

        $data = array_merge(request()->input(), [
            'password'                  => bcrypt(request()->input('password')),
            'api_token'                 => Str::random(80),
            'is_verified'               => core()->getConfigData('customer.settings.email.verification') ? 0 : 1,
            // 'customer_group_id'         => $this->customerGroupRepository->findOneWhere(['code' => 'general'])->id,
            'token'                     => md5(uniqid(rand(), true)),
            // 'subscribed_to_news_letter' => isset(request()->input()['is_subscribed']) ? 1 : 0,
        ]);

        Event::dispatch('customer.registration.before');

        $driver = $this->driverRepository->create($data);

        // Event::dispatch('customer.registration.after', $customer);

        if (! $driver) {
            session()->flash('error', trans('shop::app.customer.signup-form.failed'));

            return redirect()->back();
        }


        if (core()->getConfigData('customer.settings.email.verification')) {
            try {
                if (core()->getConfigData('emails.general.notifications.emails.general.notifications.verification')) {
                    Mail::queue(new VerificationEmail(['email' => $data['email'], 'token' => $data['token']]));
                }

                session()->flash('success', trans('shop::app.customer.signup-form.success-verify'));
            } catch (\Exception $e) {
                report($e);

                session()->flash('info', trans('shop::app.customer.signup-form.success-verify-email-unsent'));
            }
        } else {
            try {
                if (core()->getConfigData('emails.general.notifications.emails.general.notifications.registration')) {
                    Mail::queue(new RegistrationEmail(request()->all(), 'customer'));
                }

                if (core()->getConfigData('emails.general.notifications.emails.general.notifications.customer-registration-confirmation-mail-to-admin')) {
                    Mail::queue(new RegistrationEmail(request()->all(), 'admin'));
                }

                session()->flash('success', trans('shop::app.customer.signup-form.success-verify'));
            } catch (\Exception $e) {
                report($e);

                session()->flash('info', trans('shop::app.customer.signup-form.success-verify-email-unsent'));
            }
            session()->flash('success', trans('shop::app.customer.signup-form.success'));
        }

        return redirect()->route($this->_config['redirect']);
    }

    /**
     * Method to verify account.
     *
     * @param  string  $token
     * @return \Illuminate\Http\Response
     */
    public function verifyAccount($token)
    {
        $driver = $this->driverRepository->findOneByField('token', $token);

        if ($driver) {
            $this->driverRepository->update(['is_verified' => 1, 'token' => 'NULL'], $driver->id);

            $this->driverRepository->syncNewRegisteredCustomerInformations($driver);

            session()->flash('success', trans('shop::app.customer.signup-form.verified'));
        } else {
            session()->flash('warning', trans('shop::app.customer.signup-form.verify-failed'));
        }

        return redirect()->route('driver.session.index');
    }

    /**
     * Resend verification email.
     *
     * @param  string  $email
     * @return \Illuminate\Http\Response
     */
    public function resendVerificationEmail($email)
    {
        $verificationData = [
            'email' => $email,
            'token' => md5(uniqid(rand(), true)),
        ];

        $driver = $this->driverRepository->findOneByField('email', $email);

        $this->driverRepository->update(['token' => $verificationData['token']], $driver->id);

        try {
            Mail::queue(new VerificationEmail($verificationData));

            if (Cookie::has('enable-resend')) {
                \Cookie::queue(\Cookie::forget('enable-resend'));
            }

            if (Cookie::has('email-for-resend')) {
                \Cookie::queue(\Cookie::forget('email-for-resend'));
            }
        } catch (\Exception $e) {
            report($e);

            session()->flash('error', trans('shop::app.customer.signup-form.verification-not-sent'));

            return redirect()->back();
        }

        session()->flash('success', trans('shop::app.customer.signup-form.verification-sent'));

        return redirect()->back();
    }
}
