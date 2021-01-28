<?php

namespace App\Http\Requests\Test;

use Illuminate\Foundation\Http\FormRequest;

class CreateQuestion extends FormRequest
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
            'content' => 'required',
            'lesson_category_id' => 'required',
//            'answers' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'content.unique'  => 'Câu hỏi đã tồn tại',
            'content.required'  => 'Chưa nhập nội dung câu hỏi',
            'answers.required'  => 'Chưa nhập nội dung câu trả lời',
            'lesson_category_id.required'  => 'Chưa chọn loại',
        ];
    }
}
