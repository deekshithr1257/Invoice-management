<?php

namespace App\Http\Requests;

use App\Invoice;
use App\Payment;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class StoreCollectCashSaleRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('sale_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        // Get the total cash_balance sum from the database
        $totalCashBalance = DB::table('sales')->sum('cash_balance');
        return [
            'collectedCash' => [
                'required',
                'numeric',
                "max:$totalCashBalance"
            ]
        ];
    }
}
