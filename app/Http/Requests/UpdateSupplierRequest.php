<?php

namespace App\Http\Requests;

use App\Supplier;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\Response;

class UpdateSupplierRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('supplier_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {

        $supplierId = $this->route('supplier');
        return [
            'name' => [
                'required',
            ],
            "contact_number" => [
                'required',
                Rule::unique('suppliers', 'contact_number')->ignore($supplierId),
            ], 
            "email" => [
                'required',
                Rule::unique('suppliers', 'email')->ignore($supplierId),
            ],
            "address_line1" => [
                'required',
            ],
            "city" => [
                'required',
            ],
            "state" => [
                'required',
            ],
            "postal_code" => [
                'required',
            ],
            "country" => [
                'required',
            ],
        ];
    }
}
