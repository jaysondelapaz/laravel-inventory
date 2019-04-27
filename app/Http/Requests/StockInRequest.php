<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StockInRequest extends FormRequest
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
         $id = $this->id ? : 0;
        return [
           
            'product_id' => "required",
            'qty' => "required|numeric|min:1",
        ];
    }

    public function messages()
    {
        return[
            'min' => "Minimum qty is 1",
            'numeric' => "Field must be in number.",
            'required' => "Field is required."
        ];
    }
}
