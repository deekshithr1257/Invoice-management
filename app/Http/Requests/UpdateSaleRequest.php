<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
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
            'pay_out_admin' => [
                'nullable', 'numeric'
            ],
        ] + $this->getConditionalRules();
    }

    private function getConditionalRules()
    {
        if ($this->pay_out_admin === null || $this->pay_out_admin == 0) {
            return [
                'cash' => ['required', 'numeric'],
                'pay_out' => ['required', 'numeric'],
                'card' => ['required', 'numeric'],
                'cash_balance' => ['required', 'numeric'],
            ];
        }

        return [
            'cash' => ['nullable', 'numeric'],
            'pay_out' => ['nullable', 'numeric'],
            'card' => ['nullable', 'numeric'],
            'cash_balance' => ['nullable', 'numeric'],
        ];
    }
}
