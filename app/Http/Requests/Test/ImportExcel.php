<?php

namespace App\Http\Requests\Test;

use Illuminate\Foundation\Http\FormRequest;

class ImportExcel extends FormRequest
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
            'file' => 'required|max:50000|mimes:xlsx,xls'
        ];
    }

    public function messages()
    {
        return [
            'file.required'  => 'Chưa chọn file excel',
            'file.max'       => 'File tải lên tối đa 5M',
            'file.mimes'     => 'File upload phải là định dạng .xlsx hoặc .xls',
        ];
    }
}
