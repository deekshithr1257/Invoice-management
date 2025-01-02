<?php

namespace App\Http\Requests;

use App\Invoice;
use App\Payment;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class StorePaymentRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('payment_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'invoice_id' => [
                'required','exists:invoices,id',
            ],
            'store_id' => [
                'required','exists:stores,id',
            ],
            'payment_type_id' => [
                'required','exists:payment_types,id',
            ],
            'entry_date' => [
                'required',
                'date_format:' . config('panel.date_format'),
            ],
            'amount' => [
                'required',
                'numeric',
                function ($attribute, $value, $fail) {
                    $invoice = Invoice::find($this->invoice_id);
                    if ($invoice && $value > $invoice->balance) {
                        $fail("The {$attribute} must not exceed the balance of the invoice.");
                    }
                },
            ],
            'created_by' => [
                'required','exists:users,id',
            ],
        ];
    }
}
