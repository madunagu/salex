<?php

namespace Salex\MarketPlace\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfNotMerchant
{
    /**
    * Handle an incoming request.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  \Closure  $next
    * @param  string|null  $guard
    * @return mixed
    */
    public function handle($request, Closure $next, $guard = 'merchant')
    {
        if (! Auth::guard($guard)->check()) {
            return redirect()->route('merchant.session.index');
        } else {
            if (Auth::guard($guard)->user()->status == 0) {
                Auth::guard($guard)->logout();

                session()->flash('warning', trans('shop::app.customer.login-form.not-activated'));
                
                return redirect()->route('merchant.session.index');
            }
            if (Auth::guard($guard)->user()->store_id == 0 && $request->route()->action['as']!='merchant.store.create' && $request->route()->action['as']!='merchant.session.destroy') {

                session()->flash('warning', trans('marketplace::app.account.store-empty'));
                
                return redirect()->route('merchant.store.create');
            }
        }

        return $next($request);
    }
}
