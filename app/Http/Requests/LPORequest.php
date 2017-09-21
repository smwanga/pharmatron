<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LPORequest extends FormRequest
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
            'address_line1' => 'required|max:255|string',
            'address_line2' => 'nullable|max:255|string',
            'name' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'currency_id' => 'required|integer',
            'delivery_date' => 'required|date',
            'zip_code' => 'nullable',
            'city' => 'required|string',
        ];
    }
}
