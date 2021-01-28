<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LessonRequest extends FormRequest
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
            'vn_title' => 'required|max:191',
            'jp_title' => 'required|max:191',
            'course_id' => 'required',
            'image' => 'required',
            'name' => 'required|max:10',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'vn_title.required' => __('lesson.content.vn_title.required'),
            'vn_title.max' => __('lesson.content.vn_title.max'),
            'jp_title.required' => __('lesson.content.jp_title.required'),
            'jp_title.max' => __('lesson.content.jp_title.max'),
            'course_id.required'  => __('lesson.course_id'),
            'image.required'  => __('lesson.image'),
            'name.required' => 'Trường này không được để trống!',
            'name.max' => 'Trường này không được vượt quá 10 ký tự',
        ];
    }
}
