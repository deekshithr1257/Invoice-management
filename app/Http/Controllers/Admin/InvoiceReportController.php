<?php

namespace App\Http\Controllers\Admin;

use App\Invoice;
use App\Http\Controllers\Controller;
use App\Payment;
use App\Supplier;
use Barryvdh\DomPDF\PDF;
use Carbon\Carbon;
use Illuminate\Http\Request;

class InvoiceReportController extends Controller
{
    public function index(Request $request)
    {
        $supplier_id = 0;
        if($request->supplier_id){
            $supplier_id = $request->supplier_id;
        }

        $from = $request->from_date ? Carbon::createFromFormat('d-m-Y', $request->from_date)->format('Y-m-d') : null;
        $to = $request->to_date ? Carbon::createFromFormat('d-m-Y', $request->to_date)->format('Y-m-d') : null;


        $invoices = Invoice::with('supplier')
                            ->when($supplier_id != 0, function ($query) use ($supplier_id) {
                                return $query->where('supplier_id', $supplier_id);
                            });
        if ($from && $to) {
            $invoices = $invoices->whereBetween('entry_date', [$from, $to]);
        }
        // Get invoice IDs to filter payments
        $invoiceIds = $invoices->pluck('id');

        $payments = Payment::with('payment_type')
                    ->whereIn('invoice_id', $invoiceIds);

        $invoicesTotal   = $invoices->sum('amount');
        $paymentsTotal    = $payments->sum('amount');
        $groupedInvoices = $invoices->whereNotNull('supplier_id')->orderBy('amount', 'desc')->get()->groupBy('supplier_id');
        $groupedPayments  = $payments->whereNotNull('payment_type_id')->orderBy('amount', 'desc')->get()->groupBy('payment_type_id');
        $balance          = $invoicesTotal - $paymentsTotal;
        $invoiceDatas = $invoices;
        $invoices = $invoices->get();
        $invoiceDatas = $invoiceDatas->paginate(10);
        $invoicesSummary = [];

        // Current month total balance
        $currentMonth = Invoice::whereYear('entry_date', Carbon::now()->year)
                                ->whereMonth('entry_date', Carbon::now()->month)
                                ->when($supplier_id != 0, function ($query) use ($supplier_id) {
                                    return $query->where('supplier_id', $supplier_id);
                                })
                                ->sum('balance');

        $lastMonth = Carbon::now()->subMonthNoOverflow()->clone();
        $twoMonthsAgo = Carbon::now()->subMonthNoOverflow(2)->clone();
        // Last month total balance
        $period1 = Invoice::whereYear('entry_date', $lastMonth->year)
                            ->whereMonth('entry_date', $lastMonth->month)
                            ->when($supplier_id != 0, function ($query) use ($supplier_id) {
                                return $query->where('supplier_id', $supplier_id);
                            })
                            ->sum('balance');

        // Two months ago total balance
        $period2 = Invoice::whereYear('entry_date', $twoMonthsAgo->year)
                                ->whereMonth('entry_date', $twoMonthsAgo->month)
                                ->when($supplier_id != 0, function ($query) use ($supplier_id) {
                                    return $query->where('supplier_id', $supplier_id);
                                })
                                ->sum('balance');

        // Older than two months total balance
        $older = Invoice::where('entry_date', '<', Carbon::now()->subMonths(2)->startOfMonth())
                        ->when($supplier_id != 0, function ($query) use ($supplier_id) {
                            return $query->where('supplier_id', $supplier_id);
                        })
                        ->sum('balance');

        $total = $currentMonth + $period1 + $period2 + $older;
        
        foreach ($groupedInvoices as $exp) {
            foreach ($exp as $line) {
                if (!isset($invoicesSummary[$line->supplier->name])) {
                    $invoicesSummary[$line->supplier->name] = [
                        'name'   => $line->supplier->name,
                        'amount' => 0,
                    ];
                }

                $invoicesSummary[$line->supplier->name]['amount'] += $line->amount;
            }
        }

        $paymentsSummary = [];

        foreach ($groupedPayments as $inc) {
            foreach ($inc as $line) {
                if (!isset($paymentsSummary[$line->payment_type->name])) {
                    $paymentsSummary[$line->payment_type->name] = [
                        'name'   => $line->payment_type->name,
                        'amount' => 0,
                    ];
                }

                $paymentsSummary[$line->payment_type->name]['amount'] += $line->amount;
            }
        }
        $suppliers = Supplier::all();
        return view('admin.invoiceReports.index', compact(
            'invoicesSummary',
            'paymentsSummary',
            'invoicesTotal',
            'paymentsTotal',
            'balance',
            'invoices',
            'suppliers',
            'supplier_id',
            'currentMonth',
            'period1',
            'period2',
            'older',
            'total',
            'invoiceDatas'
        ));
    }

    public function download(Request $request){
        $supplier_id = 0;
        if($request->supplier_id){
            $supplier_id = $request->supplier_id;
        }

        $from = $request->from_date ? Carbon::createFromFormat('d-m-Y', $request->from_date)->format('Y-m-d') : null;
        $to = $request->to_date ? Carbon::createFromFormat('d-m-Y', $request->to_date)->format('Y-m-d') : null;


        $invoices = Invoice::with('supplier')
                            ->when($supplier_id != 0, function ($query) use ($supplier_id) {
                                return $query->where('supplier_id', $supplier_id);
                            });
        if ($from && $to) {
            $invoices = $invoices->whereBetween('entry_date', [$from, $to]);
        }
        // Get invoice IDs to filter payments
        $invoiceIds = $invoices->pluck('id');

        $payments = Payment::with('payment_type')
                    ->whereIn('invoice_id', $invoiceIds);

        $invoicesTotal   = $invoices->sum('amount');
        $paymentsTotal    = $payments->sum('amount');
        $groupedInvoices = $invoices->whereNotNull('supplier_id')->orderBy('amount', 'desc')->get()->groupBy('supplier_id');
        $groupedPayments  = $payments->whereNotNull('payment_type_id')->orderBy('amount', 'desc')->get()->groupBy('payment_type_id');
        $balance          = $invoicesTotal - $paymentsTotal;
        $invoices = $invoices->get();
        $invoicesSummary = [];

        // Current month total balance
        $currentMonth = Invoice::whereYear('entry_date', Carbon::now()->year)
                                ->whereMonth('entry_date', Carbon::now()->month)
                                ->when($supplier_id != 0, function ($query) use ($supplier_id) {
                                    return $query->where('supplier_id', $supplier_id);
                                })
                                ->sum('balance');

        $lastMonth = Carbon::now()->subMonthNoOverflow()->clone();
        $twoMonthsAgo = Carbon::now()->subMonthNoOverflow(2)->clone();
        // Last month total balance
        $period1 = Invoice::whereYear('entry_date', $lastMonth->year)
                            ->whereMonth('entry_date', $lastMonth->month)
                            ->when($supplier_id != 0, function ($query) use ($supplier_id) {
                                return $query->where('supplier_id', $supplier_id);
                            })
                            ->sum('balance');

        // Two months ago total balance
        $period2 = Invoice::whereYear('entry_date', $twoMonthsAgo->year)
                                ->whereMonth('entry_date', $twoMonthsAgo->month)
                                ->when($supplier_id != 0, function ($query) use ($supplier_id) {
                                    return $query->where('supplier_id', $supplier_id);
                                })
                                ->sum('balance');

        // Older than two months total balance
        $older = Invoice::where('entry_date', '<', Carbon::now()->subMonths(2)->startOfMonth())
                        ->when($supplier_id != 0, function ($query) use ($supplier_id) {
                            return $query->where('supplier_id', $supplier_id);
                        })
                        ->sum('balance');

        $total = $currentMonth + $period1 + $period2 + $older;

        foreach ($groupedInvoices as $exp) {
            foreach ($exp as $line) {
                if (!isset($invoicesSummary[$line->supplier->name])) {
                    $invoicesSummary[$line->supplier->name] = [
                        'name'   => $line->supplier->name,
                        'amount' => 0,
                    ];
                }

                $invoicesSummary[$line->supplier->name]['amount'] += $line->amount;
            }
        }

        $paymentsSummary = [];

        foreach ($groupedPayments as $inc) {
            foreach ($inc as $line) {
                if (!isset($paymentsSummary[$line->payment_type->name])) {
                    $paymentsSummary[$line->payment_type->name] = [
                        'name'   => $line->payment_type->name,
                        'amount' => 0,
                    ];
                }

                $paymentsSummary[$line->payment_type->name]['amount'] += $line->amount;
            }
        }
        $supplier = null;
        if($supplier_id != 0){
            $supplier = Supplier::find($supplier_id);
        }
        $pdf = app(PDF::class)->loadView('admin.invoiceReports.pdf', compact(['invoices',
            'supplier',
            'currentMonth',
            'period1',
            'period2',
            'older',
            'total']));
        return $pdf->download('Invoice-Report.pdf');
    }
}
