<?php

namespace Plugins\SampleMaster\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSupplierRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return \UserCapability::hasCapability('edit-master-supplier');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'supplier_name' => 'required|string',
            'supplier_phone' => 'nullable|string',
            'supplier_address' => 'nullable|string',
            'is_active' => 'boolean',
        ];
    }
}

