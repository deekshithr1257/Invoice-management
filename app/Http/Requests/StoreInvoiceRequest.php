<?php

namespace App\Http\Requests;

use App\Invoice;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class StoreInvoiceRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('invoice_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'entry_date' => [
                'required',
                'date_format:' . config('panel.date_format'),
            ],
            'amount'     => [
                'required',
            ],

            'image'     => [
                'nullable',
            ],
            'camera_image'     => [
                'nullable',
            ],

            
        ];
    }
}
