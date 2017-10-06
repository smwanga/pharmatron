<?php

namespace App\Http\Requests;

use Bouncer;
use Illuminate\Foundation\Http\FormRequest;

class CompanyUpdateRequest extends FormRequest
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
            'email' => 'nullable|email|unique:companies,email,'.request()->get('company_id'),
            'company_name' => 'required|string',
            'phone_number' => 'required|unique:companies,phone_number,'.request()->get('company_id'),
            'website' => 'nullable|string|url',
        ];
    }
}
