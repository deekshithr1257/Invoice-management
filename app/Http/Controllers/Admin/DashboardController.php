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

        $user = auth()->user();

        // Admin can view all data
        if ($user->role === 'admin') {
            $total = Invoice::sum('amount');
            $balance = Invoice::sum('balance');
            $paid = Payment::sum('amount');
            $invoices = Invoice::all();
        } else {
            // Store manager can view only their data
            $total = Invoice::where('created_by', $user->id)->sum('amount');
            $balance = Invoice::where('created_by', $user->id)->sum('balance');
            $paid = Payment::where('created_by', $user->id)->sum('amount');
            $invoices = Invoice::where('created_by', $user->id)->get();
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
