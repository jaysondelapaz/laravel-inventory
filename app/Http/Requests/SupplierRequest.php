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
            'name' =>'required',
            'address' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => "Enter Supplier Name!",
            'address.required' => "Enter Supplier Address!",
            'name.unique' => "Supplier has already exist!",
        ];
    }
}
