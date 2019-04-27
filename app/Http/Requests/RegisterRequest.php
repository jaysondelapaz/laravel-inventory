<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
           'email' => 'required|unique:users',
            'username' => 'required|min:4|unique:users',
            'password' => 'required|min:6|confirmed'
        ];
    }

    public function messages()
    {
        return [
            'username.required' => 'username is required',
            'username.unique' => 'The username has already been taken',
            'email.required' => 'Email is also required',
            'email.unique' => 'Email has already been taken',
            'password.required' => 'password is required',
            'password.confirmed' => "Password doe's not match",
        ];
    }
}
