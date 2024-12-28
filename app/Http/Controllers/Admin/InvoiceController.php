<?php

namespace App\Http\Controllers\Admin;

use App\Invoice;
use App\InvoiceCategory;
use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyInvoiceRequest;
use App\Http\Requests\StoreInvoiceRequest;
use App\Http\Requests\UpdateInvoiceRequest;
use App\Supplier;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class InvoiceController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('invoice_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $invoices = Invoice::when(session('selected_store_id'), function ($query, $storeId) {
                                    $query->where('store_id', $storeId);
                                })->get();

        return view('admin.invoices.index', compact('invoices'));
    }

    public function create()
    {
        abort_if(Gate::denies('invoice_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $suppliers = Supplier::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.invoices.create', compact('suppliers'));
    }

    public function store(StoreInvoiceRequest $request)
    {

        if(session('selected_store_id')){
            $storeId = session('selected_store_id');
        }else{
            session()->flash('alert', 'Please select a store before proceeding.');
            return redirect()->back();
        }
         // Validate the file input
        $validated = $request->validate([
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Adjust the file types and size as needed
            'camera_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Validation for the camera image
        ]);

        // Handle the image upload if it exists
        $imagePath = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imagePath = $image->store('invoices', 'public'); // Store in the 'invoices' directory within the public disk
        }

        // Handle the camera image upload
        $cameraImagePath = null;
        if ($request->hasFile('camera_image')) {
            $cameraImage = $request->file('camera_image');
            $cameraImagePath = $cameraImage->store('invoices/camera_images', 'public');
        }

        // Create the invoice
        $invoice = Invoice::create([
            'supplier_id' => $request->supplier_id,
            'store_id' => $storeId,
            'invoice_number' => $request->invoice_number,
            'entry_date' => $request->entry_date,
            'amount' => $request->amount,
            'balance' => $request->amount,
            'description' => $request->description,
            'image' => $imagePath, // Save the image path to the database
            'camera_image' => $cameraImagePath,
            'created_by' => $request->created_by,
        ]);
        // $invoice = Invoice::create($request->all());

        return redirect()->route('admin.invoices.index');
    }

    public function edit(Invoice $invoice)
    {

        abort_if(Gate::denies('invoice_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');


        $suppliers = Supplier::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $invoice->load('supplier', 'created_by');

        return view('admin.invoices.edit', compact('suppliers', 'invoice'));
    }

    public function update(UpdateInvoiceRequest $request, Invoice $invoice)
    {
        // Validate the file inputs
        $validated = $request->validate([
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Validation for uploaded images
            'camera_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Validation for camera images
        ]);

    
        // Initialize paths with existing values
        $imagePath = $invoice->image;
        $cameraImagePath = $invoice->camera_image;
    
        // Handle 'image' upload
        if ($request->hasFile('image')) {
            // Delete old image if it exists
            if ($imagePath && file_exists(public_path("storage/{$imagePath}"))) {
                unlink(public_path("storage/{$imagePath}"));
            }
    
            // Store new image
            $image = $request->file('image');
            $imagePath = $image->store('invoices', 'public');
        }
    
        // Handle 'camera_image' upload
        if ($request->hasFile('camera_image')) {
            // Delete old camera image if it exists
            if ($cameraImagePath && file_exists(public_path("storage/{$cameraImagePath}"))) {
                unlink(public_path("storage/{$cameraImagePath}"));
            }
    
            // Store new camera image
            $cameraImage = $request->file('camera_image');
            $cameraImagePath = $cameraImage->store('invoices/camera_images', 'public');
        }
    
        // Update the invoice
        $invoice->update([
            'supplier_id' => $request->supplier_id,
            'store_id' => $request->store_id,
            'invoice_number' => $request->invoice_number,
            'entry_date' => $request->entry_date,
            'amount' => $request->amount,
            'description' => $request->description,
            'image' => $imagePath,
            'camera_image' => $cameraImagePath,
            'created_by' => $request->created_by,
        ]);
    
        return redirect()->route('admin.invoices.index');
    }
    


    public function show(Invoice $invoice)
    {
        abort_if(Gate::denies('invoice_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $invoice->load('created_by');

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
