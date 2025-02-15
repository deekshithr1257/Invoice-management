<?php

namespace App\Http\Requests;

use App\Invoice;
use App\Payment;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class UpdateSaleRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('sale_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'store_id' => [
                'required','exists:stores,id',
            ],
            'entry_date' => [
                'required',
                'date_format:' . config('panel.date_format'),
                Rule::unique('sales', 'entry_date')
                    ->where(fn($query) => $query->where('store_id', $this->store_id))
                    ->ignore($this->id)
            ],
            'cash' => [
                'required',
                'numeric'
            ],
            'pay_out' => [
                'required',
                'numeric'
            ],
            'card' => [
                'required',
                'numeric'
            ],
            'cash_balance' => [
                'required',
                'numeric'
            ]
        ];
    }
}
