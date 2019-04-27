<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StockoutRequest extends FormRequest
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
            'product_id' => "required",
            'qty' => "required|numeric|min:1",
        ];
    }

    public function messages()
    {
        return[
        'min' => "Minimum qty is greater than 0.",
        'numiric' => 'Field must be in number.',
        'required' => "Field is require."
        ];    
    }
}
