<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest
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
        return [
            'fullname'   =>'min:0|max:191',
            'email'  => 'required|unique:users,deleted_at',
            'mobile' => 'required|unique:users,deleted_at'
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
