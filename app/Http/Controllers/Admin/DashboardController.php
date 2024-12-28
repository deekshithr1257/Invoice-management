<?php

namespace App\Http\Controllers\Admin;

use App\InvoiceCategory;
use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyInvoiceCategoryRequest;
use App\Http\Requests\StoreInvoiceCategoryRequest;
use App\Http\Requests\UpdateInvoiceCategoryRequest;
use App\Invoice;
use App\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class DashboardController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('dashboard_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        
        if(session('selected_store_id')){
            $storeId = session('selected_store_id');
        }else{
            session()->flash('alert', 'Please select a store before proceeding.');
        }
        $user = auth()->user();

        // Admin can view all data
        if ($user->role === 'admin') {
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
                                $query->where('store_id', $storeId);
                            })->all();
        } else {
            // Store manager can view only their data
            $total = Invoice::when(session('selected_store_id'), function ($query, $storeId) {
                                $query->where('store_id', $storeId);
                            })->where('created_by', $user->id)->sum('amount');
            $balance = Invoice::when(session('selected_store_id'), function ($query, $storeId) {
                                $query->where('store_id', $storeId);
                            })->where('created_by', $user->id)->sum('balance');
            $paid = Payment::when(session('selected_store_id'), function ($query, $storeId) {
                                $query->where('store_id', $storeId);
                            })->where('created_by', $user->id)->sum('amount');
            $invoices = Invoice::when(session('selected_store_id'), function ($query, $storeId) {
                                $query->where('store_id', $storeId);
                            })->where('created_by', $user->id)->get();
        }

        // Calculate payment rate
        $paymentRate = ($total > 0) ? number_format(($paid / $total) * 100, 2) : 0.00;

        return view('admin.dashboard.index', [
            'total' => $total,
            'balance' => $balance,
            'paid' => $paid,
            'paymentRate' => $paymentRate,
            'invoices' => $invoices
        ]);
    }
}
