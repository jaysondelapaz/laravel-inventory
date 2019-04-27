<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AccountRequest extends FormRequest
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
        $id = $this->id ? :0;
        return [
            'name' =>'required',
            'gender' =>'required',
            'position' =>'required',
            'contact'=>'required',
            'username' =>'required|min:4|unique:users,username,'.$id, // need this if you want to remain your old username
            'password'=> 'required|min:6|confirmed',
        ];
    }

    public function message()
    {
        return [
            'required' => "Field is required",
            'password.confirmed' => 'Password not match.',
        ];
    }
}
