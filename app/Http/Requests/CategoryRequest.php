<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
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
            'ar*.name'=> 'required',
            'en*.name'=> 'required',
//            ''=> '',
        ];
    }
    public function messages()
    {
        return [
            'ar*.name.required'=> 'name_required_ar',
            'en*.name.required'=> 'name_required_en'
        ];
    }
}
