<?php

namespace Plugins\SampleTransaction\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddPurchaseOrderItemRequest extends FormRequest
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
            'product_id' => 'required|exists:products,id',
            'qty' => 'required|integer|min:1',
            'discount' => 'nullable|numeric|min:0|max:100',
        ];
    }
}

