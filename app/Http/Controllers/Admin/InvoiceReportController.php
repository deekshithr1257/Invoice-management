<?php

namespace App\Http\Controllers\Admin;

use App\Invoice;
use App\Http\Controllers\Controller;
use App\Payment;
use Carbon\Carbon;

class InvoiceReportController extends Controller
{
    public function index()
    {
        $from = Carbon::parse(sprintf(
            '%s-%s-01',
            request()->query('y', Carbon::now()->year),
            request()->query('m', Carbon::now()->month)
        ));
        $to      = clone $from;
        $to->day = $to->daysInMonth;

        $invoices = Invoice::with('supplier')
            ->whereBetween('entry_date', [$from, $to]);

        $payments = Payment::with('payment_type')
            ->whereBetween('entry_date', [$from, $to]);

        $invoicesTotal   = $invoices->sum('amount');
        $paymentsTotal    = $payments->sum('amount');
        $groupedInvoices = $invoices->whereNotNull('supplier_id')->orderBy('amount', 'desc')->get()->groupBy('supplier_id');
        $groupedPayments  = $payments->whereNotNull('payment_type_id')->orderBy('amount', 'desc')->get()->groupBy('payment_type_id');
        $balance          = $invoicesTotal - $paymentsTotal;
        $invoices = $invoices->get();
        $invoicesSummary = [];

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

        return view('admin.invoiceReports.index', compact(
            'invoicesSummary',
            'paymentsSummary',
            'invoicesTotal',
            'paymentsTotal',
            'balance',
            'invoices'
        ));
    }
}
