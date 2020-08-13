<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
            'category_id'=>'required',
            'purchase_price'=>'required',
            'sale_price'=>'required',
            'stock'=>'required',
            'ar*.name'=> 'required',
            'en*.name'=> 'required',
        ];
    }
    public function messages()
    {
        return [
            'category_id.required'=>'القسم مطلوب',
            'purchase_price.required'=>'سعر الشراء مطلوب',
            'sale_price.required'=>'السعر مطلوب',
            'stock.required'=>'السوق مطلوب',
            'ar*.name.required'=> 'الاسم بالعربيه مطلوب',
            'en*.name.required'=> 'الاسم بالانجليزية مطلوب',
        ];
    }
}
