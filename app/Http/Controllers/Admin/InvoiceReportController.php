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

        $invoices = Invoice::with('invoice_category')
            ->whereBetween('entry_date', [$from, $to]);

        $payments = Payment::with('payment_category')
            ->whereBetween('entry_date', [$from, $to]);

        $invoicesTotal   = $invoices->sum('amount');
        $paymentsTotal    = $payments->sum('amount');
        $groupedInvoices = $invoices->whereNotNull('invoice_category_id')->orderBy('amount', 'desc')->get()->groupBy('invoice_category_id');
        $groupedPayments  = $payments->whereNotNull('payment_category_id')->orderBy('amount', 'desc')->get()->groupBy('payment_category_id');
        $profit          = $paymentsTotal - $invoicesTotal;

        $invoicesSummary = [];

        foreach ($groupedInvoices as $exp) {
            foreach ($exp as $line) {
                if (!isset($invoicesSummary[$line->invoice_category->name])) {
                    $invoicesSummary[$line->invoice_category->name] = [
                        'name'   => $line->invoice_category->name,
                        'amount' => 0,
                    ];
                }

                $invoicesSummary[$line->invoice_category->name]['amount'] += $line->amount;
            }
        }

        $paymentsSummary = [];

        foreach ($groupedPayments as $inc) {
            foreach ($inc as $line) {
                if (!isset($paymentsSummary[$line->payment_category->name])) {
                    $paymentsSummary[$line->payment_category->name] = [
                        'name'   => $line->payment_category->name,
                        'amount' => 0,
                    ];
                }

                $paymentsSummary[$line->payment_category->name]['amount'] += $line->amount;
            }
        }

        return view('admin.invoiceReports.index', compact(
            'invoicesSummary',
            'paymentsSummary',
            'invoicesTotal',
            'paymentsTotal',
            'profit'
        ));
    }
}
