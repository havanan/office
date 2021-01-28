<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;

class CourseRequest extends FormRequest
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
    public function rules(Request $request)
    {
        return [
            'name' => ['required', 'max:191', Rule::unique('courses', 'name')->ignore($request->id)],
            'videos' => 'numeric|min:0',
            'hours' => 'numeric|min:0',
            'number_of_buyers' => 'numeric|min:0',
            'price' => 'numeric|min:0',
            'sale_price' => 'numeric|min:0|lte:price',
            'expiration' => 'numeric|min:0',
            'image_info' => 'required',
            'image_banner' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Trường này không được để trống!',
            'name.max' => 'Không được vượt quá 191 ký tự!',
            'name.unique' => 'Tên này đã tồn tại!',
            'videos.numeric'  => 'Trường này chỉ bao gồm số',
            'videos.min'  => 'Giá trị không được nhỏ hơn 0',
            'hours.numeric'  => 'Trường này chỉ bao gồm số',
            'hours.min'  => 'Giá trị không được nhỏ hơn 0',
            'number_of_buyers.numeric'  => 'Trường này chỉ bao gồm số',
            'number_of_buyers.min'  => 'Giá trị không được nhỏ hơn 0',
            'price.numeric'  => 'Trường này chỉ bao gồm số',
            'price.min'  => 'Giá trị không được nhỏ hơn 0',
            'sale_price.numeric'  => 'Trường này chỉ bao gồm số',
            'sale_price.min'  => 'Giá trị không được nhỏ hơn 0',
            'sale_price.lte'  => 'Giá sale không được lớn hơn giá gốc',
            'expiration.numeric'  => 'Trường này chỉ bao gồm số',
            'expiration.min'  => 'Giá trị không được nhỏ hơn 0',
            'image_info.required' => 'Trường này không được để trống!',
            'image_banner.required' => 'Trường này không được để trống!',
        ];
    }
}
