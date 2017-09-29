<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUsersRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return \Bouncer::allows('users.manage');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.request()->get('user_id'),
            'role' => 'required',
            'phone_number' => 'required|min:8|max:13',
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
        ];
    }
}
