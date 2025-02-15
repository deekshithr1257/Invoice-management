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
        $totalCashBalance = $sales->sum('cash_balance');
        $totalCard = $sales->sum('card');
        $sales->sum('card');
        $sales = $sales->orderBy('entry_date','DESC')
                            ->paginate(10);

        return view('admin.sales.index', compact(['sales', 'totalCashBalance', 'totalCard']));
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
        $sale->update([
            'store_id' => $request->store_id,
            'entry_date' => $request->entry_date,
            'cash' => $request->cash,
            'pay_out' => $request->pay_out,
            'cash_balance' => $request->cash_balance,
            'card' => $request->card,
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
            $storeId = session('selected_store_id');
            $salesNotPayOutAdmin = Sale::where('cash_balance', '!=', 0)
                                        ->where('store_id',$storeId)
                                        ->orderBy('entry_date','ASC')
                                        ->get();
            $collectedCash = $request->collectedCash;

            foreach ($salesNotPayOutAdmin as $index => $sale) {
                if ($collectedCash <= 0) {
                    break;
                }

                if ($collectedCash >= $sale->cash_balance) {
                    $collectedCash -= $sale->cash_balance;
                    $sale->pay_out_admin = $sale->pay_out_admin+$sale->cash_balance;
                    $sale->cash_balance = 0;
                } else {
                    $sale->cash_balance -= $collectedCash;
                    $sale->pay_out_admin = $sale->pay_out_admin+$collectedCash;
                    $collectedCash = 0;
                }
                $sale->admin_collection_date = Carbon::now()->format('Y/m/d');
                $sale->save();
            }
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
