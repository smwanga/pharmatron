<?php

namespace App\Http\Requests;

use Bouncer;
use Illuminate\Foundation\Http\FormRequest;

class UsersRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Bouncer::allows('users_manage');
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
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed|min:6',
            'role' => 'required',
            'phone_nuber' => 'required|min:8|max:13',
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
        ];
    }
}
