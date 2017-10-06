<?php

namespace App\Http\Requests;

use Bouncer;
use Illuminate\Foundation\Http\FormRequest;

class CompanyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Bouncer::allows('can_add_companies');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => 'nullable|email|unique:companies',
            'company_name' => 'required|string',
            'phone_number' => 'required|unique:companies',
            'website' => 'nullable|string|url',
        ];
    }
}
