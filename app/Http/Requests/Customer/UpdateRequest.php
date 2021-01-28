<?php

namespace App\Http\Requests\Customer;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
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
        $id = $this->route('id');
        return [
            'email'  => 'required|email|unique:customers,email,'.$id.',id',
//            'mobile' => 'unique:customers,mobile,'.$id.',id'
        ];
    }
    public function messages()
    {
        return [
            'email.unique'  => 'Email đã tồn tại',
            'mobile.unique'  => 'Số điện thoại đã tồn tại',
        ];
    }
}
