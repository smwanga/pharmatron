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
            'item_name' => 'required',
            'generic_name' => 'required_if:item_name,',
            'stock_code' => 'required|unique:products',
            'barcode' => 'nullable|numeric|unique:products',
            'category_id' => 'required',
            'unit' => 'required',
            'alert_level' => 'nullable|numeric|min:0',
            'description' => 'required|string',
        ];
    }

    /**
     * undocumented function.
     *
     * @author
     **/
    public function messages()
    {
        return ['generic_name.required_if' => 'This field is required when the item name is not specified'];
    }
}
