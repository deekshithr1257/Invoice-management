<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\InvoiceCategory;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreInvoiceCategoryRequest;
use App\Http\Requests\UpdateInvoiceCategoryRequest;
use App\Http\Resources\Admin\InvoiceCategoryResource;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class InvoiceCategoryApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('invoice_category_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new InvoiceCategoryResource(InvoiceCategory::with(['created_by'])->get());
    }

    public function store(StoreInvoiceCategoryRequest $request)
    {
        $invoiceCategory = InvoiceCategory::create($request->all());

        return (new InvoiceCategoryResource($invoiceCategory))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(InvoiceCategory $invoiceCategory)
    {
        abort_if(Gate::denies('invoice_category_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new InvoiceCategoryResource($invoiceCategory->load(['created_by']));
    }

    public function update(UpdateInvoiceCategoryRequest $request, InvoiceCategory $invoiceCategory)
    {
        $invoiceCategory->update($request->all());

        return (new InvoiceCategoryResource($invoiceCategory))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(InvoiceCategory $invoiceCategory)
    {
        abort_if(Gate::denies('invoice_category_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $invoiceCategory->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
