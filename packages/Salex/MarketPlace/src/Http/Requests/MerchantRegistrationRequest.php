<?php

namespace Salex\MarketPlace\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Webkul\Customer\Facades\Captcha;

class MerchantRegistrationRequest extends FormRequest
{
    /**
     * Define your rules.
     *
     * @var array
     */
    private $rules = [
        'first_name' => 'string|required',
        'last_name'  => 'string|required',
        'phone' => 'string|required',
        'email'      => 'email|required|unique:merchants,email',
        'password'   => 'confirmed|min:6|required',
    ];

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return Captcha::getValidations($this->rules);
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        return Captcha::getValidationMessages();
    }
}
