<?php

namespace App\Http\Requests;

use App\Supplier;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class StoreSupplierRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('supplier_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'name' => [
                'required',
            ],
            "contact_number" => [
                'required','unique:suppliers,contact_number'
            ], 
            "email" => [
                'required','unique:suppliers,email'
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
