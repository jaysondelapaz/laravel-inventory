<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
            'supplier_id' => 'required',
            'productname' => 'required|unique:products',
            'price' => 'integer'
        ];
    }

    public function message()
    {
        return [
            'supplier_id.required' => 'Supplier required',
            'productname.required' =>'ProductName required',
            'productname.unique' => 'Productname already exist',
            'productcost.required' => 'ProductCost required',
        ];
    }
}
