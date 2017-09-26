<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LPOItemRequest extends FormRequest
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
            'product_name' => 'required|string|max:255',
            'qty' => 'required|numeric|min:1',
            'unit_cost' => 'required|numeric|min:0',
            'notes' => 'nullable|string|max:255',
        ];
    }
}