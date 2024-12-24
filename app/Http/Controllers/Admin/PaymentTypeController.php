<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyPaymentTypeRequest;
use App\Http\Requests\StorePaymentTypeRequest;
use App\Http\Requests\UpdatePaymentTypeRequest;
use App\PaymentType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class PaymentTypeController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('payment_type_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $paymentTypes = PaymentType::all();

        return view('admin.paymentTypes.index', compact('paymentTypes'));
    }

    public function create()
    {
        abort_if(Gate::denies('payment_type_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.paymentTypes.create');
    }

    public function store(StorePaymentTypeRequest $request)
    {
        $paymentType = PaymentType::create($request->all());

        return redirect()->route('admin.payment-types.index');
    }

    public function edit(PaymentType $paymentType)
    {
        abort_if(Gate::denies('payment_type_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $paymentType->load('created_by');

        return view('admin.paymentTypes.edit', compact('paymentType'));
    }

    public function update(UpdatePaymentTypeRequest $request, PaymentType $paymentType)
    {
        $paymentType->update($request->all());

        return redirect()->route('admin.payment-types.index');
    }

    public function show(PaymentType $paymentType)
    {
        abort_if(Gate::denies('payment_type_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $paymentType->load('created_by');

        return view('admin.paymentTypes.show', compact('paymentType'));
    }

    public function destroy(PaymentType $paymentType)
    {
        abort_if(Gate::denies('payment_type_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $paymentType->delete();

        return back();
    }

    public function massDestroy(MassDestroyPaymentTypeRequest $request)
    {
        PaymentType::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
