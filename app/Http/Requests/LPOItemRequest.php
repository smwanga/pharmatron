<?php

namespace App\Http\Requests;

use Bouncer;
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
        return Bouncer::allows('create_purchase_orders');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'product_id' => 'required|integer|exists:products,id',
            'product_name' => 'required|string|max:255',
            'qty' => 'required|numeric|min:1',
            'unit_cost' => 'required|numeric|min:0',
            'notes' => 'max:255',
        ];
    }

    /**
     * Return custom alidation message.
     *
     * @return array
     **/
    public function messages()
    {
        return ['product_id.*' => 'Please select a product that has already been created'];
    }
}
