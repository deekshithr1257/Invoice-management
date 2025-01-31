<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyPaymentRequest;
use App\Http\Requests\StorePaymentRequest;
use App\Http\Requests\UpdatePaymentRequest;
use App\Invoice;
use App\Payment;
use App\PaymentType;
use App\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('payment_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $supplierId = 0;
        if($request->supplier_id){
            $supplierId = $request->supplier_id;
        }
        $storeId = session('selected_store_id');
        $suppliers = Supplier::all();
        $payments = Payment::when(session('selected_store_id'), function ($query, $storeId) {
                                $query->where('store_id', $storeId);
                            })->when($supplierId != 0, function ($query) use ($supplierId) {
                                return $query->whereHas('invoice', function ($q) use ($supplierId) {
                                    $q->where('supplier_id', $supplierId);
                                });
                            })
                            ->orderBy('created_at','DESC')
                            ->paginate(10);

        return view('admin.payments.index', compact('payments', 'suppliers', 'supplierId'));
    }

    public function create()
    {
        abort_if(Gate::denies('payment_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $payment_types = PaymentType::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        $store_id = session('selected_store_id');
        $invoices = Invoice::when(session('selected_store_id'), function ($query, $store_id) {
                                $query->where('store_id', $store_id);
                            })
                    ->where('balance','!=',0)
                    ->get()->pluck('invoice_number', 'id')->prepend(trans('global.pleaseSelect'), '');
        return view('admin.payments.create', compact('payment_types', 'invoices', 'store_id'));
    }

    public function store(StorePaymentRequest $request)
    {
        $payment = Payment::create($request->all());
        $invoice = Invoice::findOrFail($payment->invoice_id);
        $invoice->balance = $invoice->balance - $payment->amount;
        $invoice->save();
        return redirect()->route('admin.payments.index');
    }

    public function edit(Payment $payment)
    {
        abort_if(Gate::denies('payment_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $payment_types = PaymentType::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        $store_id = session('selected_store_id');
        $invoices = Invoice::when(session('selected_store_id'), function ($query, $store_id) {
                                $query->where('store_id', $store_id);
                            })
                    ->where('balance','!=',0)
                    ->get()->pluck('invoice_number', 'id')->prepend(trans('global.pleaseSelect'), '');
        $payment->load('payment_type');

        return view('admin.payments.edit', compact('payment_types', 'payment', 'store_id', 'invoices'));
    }

    public function update(UpdatePaymentRequest $request, Payment $payment)
    {
        $invoice = Invoice::findOrFail($payment->invoice_id);
        $invoice->balance = ($invoice->balance + $payment->amount) - $request->amount;
        $invoice->save();
        $payment->update($request->all());
        return redirect()->route('admin.payments.index');
    }

    public function show(Payment $payment)
    {
        abort_if(Gate::denies('payment_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $payment->load('payment_type', 'created_by');

        return view('admin.payments.show', compact('payment'));
    }

    public function destroy(Payment $payment)
    {
        abort_if(Gate::denies('payment_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $payment->delete();

        return redirect()->route('admin.payments.index')->with('success', 'Payment deleted successfully.');
    }

    public function massDestroy(MassDestroyPaymentRequest $request)
    {
        Payment::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
