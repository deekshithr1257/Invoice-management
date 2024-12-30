<?php

namespace App\Http\Requests;

use App\Store;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\Response;

class UpdateStoreRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('store_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        $storeId = $this->route('store');
        return [
            'name' => [
                'required',
            ],
            "contact_number" => [
                'required',
                Rule::unique('stores', 'contact_number')->ignore($storeId),
            ], 
            "email" => [
                'required',
                Rule::unique('stores', 'email')->ignore($storeId),
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
