<?php

namespace App\Http\Controllers\Admin;

use App\InvoiceCategory;
use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyInvoiceCategoryRequest;
use App\Http\Requests\StoreInvoiceCategoryRequest;
use App\Http\Requests\UpdateInvoiceCategoryRequest;
use App\Invoice;
use App\Payment;
use App\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('dashboard_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        
        if(session('selected_store_id')){
            $storeId = session('selected_store_id');
        }else{
            session()->flash('alert', 'Please select a store before proceeding.');
        }
        $supplierId = 0;
        if($request->supplier_id){
            $supplierId = $request->supplier_id;
        }
        $total = Invoice::when(session('selected_store_id'), function ($query, $storeId) {
                    $query->where('store_id', $storeId);
                })->sum('amount');
        $balance = Invoice::when(session('selected_store_id'), function ($query, $storeId) {
                    $query->where('store_id', $storeId);
                })->sum('balance');
        $paid = Payment::when(session('selected_store_id'), function ($query, $storeId) {
                    $query->where('store_id', $storeId);
                })->sum('amount');
        $invoices = Invoice::when(session('selected_store_id'), function ($query, $storeId) {
                    return $query->where('store_id', $storeId);
                })->when($supplierId != 0, function ($query) use ($supplierId) {
                    return $query->where('supplier_id', $supplierId);
                })->paginate(10);
        $suppliers = Supplier::all();
        // Calculate payment rate
        $paymentRate = ($total > 0) ? number_format(($paid / $total) * 100, 2) : 0.00;

        return view('admin.dashboard.index', [
            'total' => $total,
            'balance' => $balance,
            'paid' => $paid,
            'paymentRate' => $paymentRate,
            'invoices' => $invoices,
            'suppliers' => $suppliers,
            'supplier_id' => $supplierId
        ]);
    }
}
