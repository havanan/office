<?php

namespace App\Http\Requests\News;

use Illuminate\Foundation\Http\FormRequest;

class CreateNewsRequest extends FormRequest
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
            'title'       => 'required|max:200',//|unique:news,title->check trùng tiêu đề
            'description' => 'required',
            'content'     => 'required',
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
            'title.required' => __('news.news.title.required'),
            'title.max' => __('news.news.title.max'),
            'title.exists' => __('news.news.title.exists'),

            'category_id.required' => __('news.news.category_id.required'),
            'description.required' => __('news.news.description.required'),
            'content.required' => __('news.news.content.required'),


        ];
    }
}
