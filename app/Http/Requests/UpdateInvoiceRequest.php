<?php

namespace App\Http\Requests;

use App\Invoice;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\Response;

class UpdateInvoiceRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('invoice_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        $invoiceId = $this->route('invoice');
        return [
            'supplier_id'     => [
                'required',
            ],
            'invoice_number'     => [
                'required',
                Rule::unique('invoices', 'invoice_number')->ignore($invoiceId),
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
            'image'     => [
                'nullable',
            ],
            'camera_image'     => [
                'nullable',
            ],
        ];
    }
}
