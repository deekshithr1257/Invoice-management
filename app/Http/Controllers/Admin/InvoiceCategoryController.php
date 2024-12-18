<?php

namespace App\Http\Controllers\Admin;

use App\InvoiceCategory;
use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyInvoiceCategoryRequest;
use App\Http\Requests\StoreInvoiceCategoryRequest;
use App\Http\Requests\UpdateInvoiceCategoryRequest;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class InvoiceCategoryController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('invoice_category_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $invoiceCategories = InvoiceCategory::all();

        return view('admin.invoiceCategories.index', compact('invoiceCategories'));
    }

    public function create()
    {
        abort_if(Gate::denies('invoice_category_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.invoiceCategories.create');
    }

    public function store(StoreInvoiceCategoryRequest $request)
    {
        $invoiceCategory = InvoiceCategory::create($request->all());

        return redirect()->route('admin.invoice-categories.index');
    }

    public function edit(InvoiceCategory $invoiceCategory)
    {
        abort_if(Gate::denies('invoice_category_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $invoiceCategory->load('created_by');

        return view('admin.invoiceCategories.edit', compact('invoiceCategory'));
    }

    public function update(UpdateInvoiceCategoryRequest $request, InvoiceCategory $invoiceCategory)
    {
        $invoiceCategory->update($request->all());

        return redirect()->route('admin.invoice-categories.index');
    }

    public function show(InvoiceCategory $invoiceCategory)
    {
        abort_if(Gate::denies('invoice_category_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $invoiceCategory->load('created_by');

        return view('admin.invoiceCategories.show', compact('invoiceCategory'));
    }

    public function destroy(InvoiceCategory $invoiceCategory)
    {
        abort_if(Gate::denies('invoice_category_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $invoiceCategory->delete();

        return back();
    }

    public function massDestroy(MassDestroyInvoiceCategoryRequest $request)
    {
        InvoiceCategory::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
