<?php

namespace Salex\Driver\Http\Controllers\Shop;

use Cookie;
use Illuminate\Support\Facades\Event;
use Webkul\Customer\Http\Requests\CustomerLoginRequest;

class SessionController extends Controller
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
     * @return void
     */
    public function __construct()
    {
        $this->_config = request('_config');
    }

    /**
     * Display the resource.
     *
     * @return \Illuminate\View\View
     */
    public function show()
    {
        return auth()->guard('driver')->check()
            ? redirect()->route('driver.dashboard.index')
            : view($this->_config['view']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  \Webkul\Customer\Http\Requests\CustomerLoginRequest $request
     * @return \Illuminate\Http\Response
     */
    public function create(CustomerLoginRequest $request)
    {
        $request->validated();

        if (! auth()->guard('driver')->attempt($request->only(['email', 'password']))) {
            session()->flash('error', trans('shop::app.customer.login-form.invalid-creds'));

            return redirect()->back();
        }

        // if (auth()->guard('driver')->user()->status == 0) {
        //     auth()->guard('driver')->logout();

        //     session()->flash('warning', trans('shop::app.customer.login-form.not-activated'));

        //     return redirect()->back();
        // }

        // if (auth()->guard('driver')->user()->is_verified == 0) {
        //     session()->flash('info', trans('shop::app.customer.login-form.verify-first'));

        //     Cookie::queue(Cookie::make('enable-resend', 'true', 1));

        //     Cookie::queue(Cookie::make('email-for-resend', $request->get('email'), 1));

        //     auth()->guard('driver')->logout();

        //     return redirect()->back();
        // }

        /**
         * Event passed to prepare cart after login.
         */
        Event::dispatch('merchant.after.login', $request->get('email'));

        return redirect()->intended(route($this->_config['redirect']));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        auth()->guard('driver')->logout();

        Event::dispatch('driver.after.logout', $id);

        return redirect()->route($this->_config['redirect']);
    }
}
