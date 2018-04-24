<?php

namespace Plugins\SampleTransaction\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreatePurchaseOrderRequest extends FormRequest
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
            'document_number' => 'required|string',
            'supplier_id' => 'required|exists:suppliers,id',
            'order_date' => 'required|date',
            'estimated_delivery_date' => 'nullable|date',
            'is_applied' => 'nullable|boolean',
            'is_void' => 'nullable|boolean',
        ];
    }
}
