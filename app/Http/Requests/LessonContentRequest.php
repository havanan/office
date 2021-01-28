<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use App\Models\LessonContent;

class LessonContentRequest extends FormRequest
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
        if($request->is_test) $request->merge([
            'video_id' => 0,
        ]);
        return [
            'title' => ['max:191'],
            'content' => 'required',
            'image' => 'required',
            'video_id' => 'required',
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
            // 'title.required' => __('lesson.content.title.required'),
            'title.max' => __('lesson.content.title.max'),
            // 'title.unique' => __('lesson.content.title.unique'),
            'content.required'  => __('lesson.content.content'),
            'image.required'  => __('lesson.content.content'),
            'video_id.required'  => __('lesson.content.video'),
        ];
    }
}
