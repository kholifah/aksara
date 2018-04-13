<?php

namespace Plugins\SampleMaster\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateProductRequest extends FormRequest
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
            'supplier_id' => 'required|integer|exists:suppliers,id',
            'name' => 'required|string|max:100',
            'code' => 'required|string|max:3',
            'price' => 'required|numeric',
            'stock' => 'required|numeric',
            'date_product' => 'required|date',
            'date_expired' => 'required|date',
        ];
    }
}

