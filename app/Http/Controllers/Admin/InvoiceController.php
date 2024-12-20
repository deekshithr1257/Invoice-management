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
        'invoice_category_id' => $request->invoice_category_id,
        'entry_date' => $request->entry_date,
        'amount' => $request->amount,
        'description' => $request->description,
        'image' => $imagePath, // Save the image path to the database
        'camera_image' => $cameraImagePath,
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
            'invoice_category_id' => $request->invoice_category_id,
            'entry_date' => $request->entry_date,
            'amount' => $request->amount,
            'description' => $request->description,
            'image' => $imagePath, // Update the image path in the database
            'camera_image' => $cameraImagePath, // Update the camera image path
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
