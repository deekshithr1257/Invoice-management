<?php

namespace App\Http\Requests;

use Carbon\Carbon;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\Response;

class StoreSaleRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('sale_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

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
                Rule::unique('sales', 'entry_date')
                    ->where(fn($query) => $query->where('store_id', $this->store_id)->where('pay_out_admin',0))
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
            ],
            'created_by' => [
                'required','exists:users,id',
            ],
        ];
    }

    public function prepareForValidation()
    {
        // Convert the entry_date format in the request before validation
        if ($this->has('entry_date')) {
            // Parse the incoming date (e.g., 15-02-2025) to the format the database expects (2025-02-15)
            $this->merge([
                'entry_date' => Carbon::createFromFormat(config('panel.date_format'), $this->entry_date)->format('Y-m-d'),
            ]);
        }
    }

    /**
     * Get custom error messages for validation failures.
     */
    public function messages(): array
    {
        return [
            'entry_date.unique' => 'An entry already exists for this store on the selected date.'
        ];
    }
}
