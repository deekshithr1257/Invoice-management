<?php

namespace App\Http\Controllers\Admin;

use App\Invoice;
use App\InvoiceCategory;
use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyInvoiceRequest;
use App\Http\Requests\StoreInvoiceRequest;
use App\Http\Requests\StorePaymentRequest;
use App\Http\Requests\UpdateInvoiceRequest;
use App\Payment;
use App\PaymentType;
use App\Supplier;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class InvoiceController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('invoice_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $supplier_id = 0;
        if($request->supplier_id){
            $supplier_id = $request->supplier_id;
        }
        $storeId = session('selected_store_id');
        $invoices = Invoice::when(session('selected_store_id'), function ($query, $storeId) {
                                return $query->where('store_id', $storeId);
                            })->when($supplier_id != 0, function ($query) use ($supplier_id) {
                                return $query->where('supplier_id', $supplier_id);
                            })->paginate(10);
        $suppliers = Supplier::all();
        return view('admin.invoices.index', compact('invoices','suppliers', 'supplier_id'));
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
        // Create the invoice
        $invoice = Invoice::create([
            'supplier_id' => $request->supplier_id,
            'store_id' => $storeId,
            'invoice_number' => $request->invoice_number,
            'entry_date' => $request->entry_date,
            'amount' => $request->amount,
            'discount' => $request->discount,
            'discount_type' => $request->discount_type,
            'original_amount' => $request->original_amount,
            'balance' => $request->amount,
            'description' => $request->description,
            'created_by' => $request->created_by,
        ]);

         // Handle the camera image upload
        $path = null;
        $images = [];
        if ($request->hasFile('camera_images')) {
            $images = $request->camera_images;
        }else if(($request->hasFile('image_files'))){
            $images = $request->image_files;
        }
        if(!empty($images)){
            if (!is_array($images)) {
                $images = [$images]; // Convert a single file to an array for consistency
            }
            foreach($images as $image){
                $path = $image->store('invoices', 'public');
                    // Save the image path to the database
                $invoice->images()->create([
                    'image_path' => $path,
                ]);
            }
        }
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
        $storeId = session('selected_store_id');
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
            'store_id' => $storeId,
            'invoice_number' => $request->invoice_number,
            'entry_date' => $request->entry_date,
            'amount' => $request->amount,
            'discount' => $request->discount,
            'discount_type' => $request->discount_type,
            'original_amount' => $request->original_amount,
            'description' => $request->description,
            'image' => $imagePath,
            'camera_image' => $cameraImagePath
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

        return redirect()->route('admin.invoices.index')->with('success', 'Invoice deleted successfully.');
    }

    public function massDestroy(MassDestroyInvoiceRequest $request)
    {
        Invoice::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function downloadInvoice($imageName)
    {
        // Define the path to the image file. This assumes images are stored in public/storage
        $filePath = public_path('storage/invoices/' . $imageName);
        
        // Check if the file exists
        if (file_exists($filePath)) {
            // Return the file as a download response
            return response()->download($filePath);
        }

        // If the file does not exist, return an error response
        return response()->json(['error' => 'File not found'], 404);
    }

    public function getPayment($invoiceId)
    {
        abort_if(Gate::denies('invoice_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $invoice = Invoice::findOrFail($invoiceId);
        $payment_types = PaymentType::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        return view('admin.invoices.payment', compact('invoice','payment_types'));
    }

    public function payment(StorePaymentRequest $request){
        $payment = Payment::create($request->all());
        $invoice = Invoice::findOrFail($payment->invoice_id);
        $invoice->balance = $invoice->balance - $payment->amount;
        $invoice->save();
        return redirect()->route('admin.invoices.show',$invoice->id);
    }

    public function getBalance($id)
    {
        $invoice = Invoice::find($id);

        if (!$invoice) {
            return response()->json(['error' => 'Invoice not found'], 404);
        }

        return response()->json(['balance' => $invoice->balance]);
    }
}
