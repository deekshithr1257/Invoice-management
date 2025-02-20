<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroySaleRequest;
use App\Http\Requests\StoreCollectCashSaleRequest;
use App\Http\Requests\StoreSaleRequest;
use App\Http\Requests\UpdateSaleRequest;
use App\Sale;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class SalesController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('sale_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $storeId = session('selected_store_id');
        $sales = Sale::when(session('selected_store_id'), function ($query, $storeId) {
                                $query->where('store_id', $storeId);
                            });
        $totalCash = $sales->sum('cash');
        $totalPayOut = $sales->sum('pay_out');
        $totalCashBalance = $sales->sum('cash_balance');
        $totalCashCollectedByAdmin = $sales->sum('pay_out_admin');
        $balanceCash = number_format(($totalCashBalance - $totalCashCollectedByAdmin), 2, '.', '');
        $totalCard = $sales->sum('card');
        $sales->sum('card');
        $sales = $sales->orderBy('entry_date','DESC')
                        ->orderByRaw("CASE WHEN pay_out_admin IS NOT NULL AND pay_out_admin != 0 THEN 1 ELSE 0 END DESC")
                        ->paginate(10);

        return view('admin.sales.index', 
            compact(['sales', 'totalCashBalance', 
                    'totalCard', 
                    'totalCash',
                    'totalCashCollectedByAdmin',
                    'balanceCash',
                    'totalPayOut'
                ])
        );
    }

    public function create()
    {
        abort_if(Gate::denies('sale_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $store_id = session('selected_store_id');
        return view('admin.sales.create', compact('store_id'));
    }

    public function store(StoreSaleRequest $request)
    {
        Sale::create($request->all());
        return redirect()->route('admin.sales.index');
    }

    public function edit(Sale $sale)
    {
        abort_if(Gate::denies('sale_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $store_id = session('selected_store_id');
        return view('admin.sales.edit', compact('sale', 'store_id'));
    }

    public function update(UpdateSaleRequest $request, Sale $sale)
    {
        // Update invoice details
        if($request->pay_out_admin != 0){
            $request->cash = 0;
            $request->pay_out = 0;
            $request->cash_balance = 0;
            $request->card = 0;
        }else{
            $request->pay_out_admin = 0;
        }
        $sale->update([
            'store_id' => $request->store_id,
            'entry_date' => $request->entry_date,
            'cash' => $request->cash,
            'pay_out' => $request->pay_out,
            'cash_balance' => $request->cash_balance,
            'card' => $request->card,
            'pay_out_admin' => $request->pay_out_admin,
            'description' => $request->description,
        ]);
        return redirect()->route('admin.sales.index');
    }

    public function show(Sale $sale)
    {
        abort_if(Gate::denies('sale_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $sale->load('created_by');

        return view('admin.sales.show', compact('sale'));
    }

    public function destroy(Sale $sale)
    {
        abort_if(Gate::denies('sale_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $sale->delete();

        return redirect()->route('admin.sales.index')->with('success', 'Sale deleted successfully.');
    }

    public function massDestroy(MassDestroySaleRequest $request)
    {
        Sale::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function collectCash(StoreCollectCashSaleRequest $request){
        try{
            $sale = new Sale();
            $sale->store_id = session('selected_store_id');
            $sale->entry_date = $request->entryDate;
            $sale->pay_out_admin = $request->collectedCash;
            $sale->pay_out_admin = $request->collectedCash;
            $sale->created_by = auth()->id();
            $sale->save();
            return response()->json(['message' => 'Cash collected successfully!'], 200);
        } catch (\Exception $e) {
            Log::error('Collection Error: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json(['message' => 'Cash collection failed! ' . $e->getMessage()], 500);
        }
    }
}
