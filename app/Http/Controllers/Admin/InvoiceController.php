<?php

namespace App\Http\Controllers\Admin;

use App\Invoice;
use App\InvoiceCategory;
use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyInvoiceRequest;
use App\Http\Requests\StoreInvoiceRequest;
use App\Http\Requests\UpdateInvoiceRequest;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class InvoiceController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('invoice_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $invoices = Invoice::all();

        return view('admin.invoices.index', compact('invoices'));
    }

    public function create()
    {
        abort_if(Gate::denies('invoice_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $invoice_categories = InvoiceCategory::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.invoices.create', compact('invoice_categories'));
    }

    public function store(StoreInvoiceRequest $request)
    {

         // Validate the file input
    $validated = $request->validate([
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Adjust the file types and size as needed
    ]);

    // Handle the image upload if it exists
    $imagePath = null;
    if ($request->hasFile('image')) {
        $image = $request->file('image');
        $imagePath = $image->store('invoices', 'public'); // Store in the 'invoices' directory within the public disk
    }

    // Create the invoice
    $invoice = Invoice::create([
        'invoice_category_id' => $request->invoice_category_id,
        'entry_date' => $request->entry_date,
        'amount' => $request->amount,
        'description' => $request->description,
        'image' => $imagePath, // Save the image path to the database
    ]);
        // $invoice = Invoice::create($request->all());

        return redirect()->route('admin.invoices.index');
    }

    public function edit(Invoice $invoice)
    {

        abort_if(Gate::denies('invoice_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');


        $invoice_categories = InvoiceCategory::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $invoice->load('invoice_category', 'created_by');

        return view('admin.invoices.edit', compact('invoice_categories', 'invoice'));
    }

    public function update(UpdateInvoiceRequest $request, Invoice $invoice)
{
    // Validate the file input
    $validated = $request->validate([
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Adjust the file types and size as needed
    ]);

    // Handle the image upload
    if ($request->hasFile('image')) {
        // Delete the old image if it exists
        if ($invoice->image && file_exists(public_path("storage/{$invoice->image}"))) {
            unlink(public_path("storage/{$invoice->image}"));
        }

        // Store the new image
        $image = $request->file('image');
        $imagePath = $image->store('invoices', 'public'); // Store in the 'invoices' directory within the public disk
    } else {
        // Retain the old image path if no new image is uploaded
        $imagePath = $invoice->image;
    }

    // Update the invoice
    $invoice->update([
        'invoice_category_id' => $request->invoice_category_id,
        'entry_date' => $request->entry_date,
        'amount' => $request->amount,
        'description' => $request->description,
        'image' => $imagePath, // Update the image path in the database
    ]);

    return redirect()->route('admin.invoices.index');
}


    public function show(Invoice $invoice)
    {
        abort_if(Gate::denies('invoice_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $invoice->load('invoice_category', 'created_by');

        return view('admin.invoices.show', compact('invoice'));
    }

    public function destroy(Invoice $invoice)
    {
        abort_if(Gate::denies('invoice_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $invoice->delete();

        return back();
    }

    public function massDestroy(MassDestroyInvoiceRequest $request)
    {
        Invoice::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
