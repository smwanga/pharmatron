<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SupplierRequest extends FormRequest
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
            'supplier_email' => 'nullable|email|unique:suppliers',
            'supplier_name' => 'required|string',
            'supplier_phone' => 'required|unique:suppliers',
            'supplier_website' => 'nullable|string|url',
        ];
    }

    /**
     * Error messages.
     *
     * @return array
     **/
    public function messages()
    {
        return [
            'supplier_website.url' => trans('messages.validation.suppliers.url'),
        ];
    }

    /**
     * Error messages.
     *
     * @return array
     **/
    public static function getMessages()
    {
        $instance = new static();

        return $instance->messages();
    }
}
