<?php

namespace App\Http\Requests;

use App\Invoice;
use Illuminate\Support\Facades\Gate;
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
            'supplier_id'     => [
                'required',
            ],
            'invoice_number'     => [
                'required',
                'unique:invoices,invoice_number'
            ],
            'entry_date' => [
                'required',
                'date_format:' . config('panel.date_format'),
            ],
            'amount'     => [
                'required',
            ],
            'original_amount' => [
                'required',
            ],
            'discount_type' => [
                'required',
            ],
            'discount' => [
                'required',
            ],
            'created_by'     => [
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
