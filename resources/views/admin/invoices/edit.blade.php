@extends('layouts.admin')
@section('content')

<link href="{{asset('plugins/fileuploads/css/fileupload.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('plugins/fancyuploder/fancy_fileupload.css')}}" rel="stylesheet" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

<div class="content-body">
    <!-- <div class="row page-titles mx-0">
        <div class="col p-md-0">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="javascript:void(0)">Invoice</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Edit</a></li>
            </ol>
        </div>
    </div> -->

    <!-- row -->
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">{{ trans('global.edit') }} {{ trans('cruds.invoice.title_singular') }}</h4>
                        <div class="basic-form">
                            <form action="{{ route("admin.invoices.update", [$invoice->id]) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <!-- Invoice Category -->
                                <div class="form-group {{ $errors->has('supplier_id') ? 'has-error' : '' }}">
                                    <label for="supplier_id">{{ trans('cruds.invoice.fields.supplier') }}</label>
                                    <select name="supplier_id" id="supplier_id" class="form-control select2">
                                        @foreach($suppliers as $id => $supplier)
                                            <option value="{{ $id }}" {{ (isset($invoice) && $invoice->supplier ? $invoice->supplier->id : old('supplier_id')) == $id ? 'selected' : '' }}>{{ $supplier }}</option>
                                        @endforeach
                                    </select>
                                    @if($errors->has('supplier_id'))
                                        <em class="invalid-feedback">
                                            {{ $errors->first('supplier_id') }}
                                        </em>
                                    @endif
                                </div>

                                <!-- Entry Date -->

                                <div class="form-group {{ $errors->has('entry_date') ? 'has-error' : '' }}">
                                    <label for="entry_date">{{ trans('cruds.invoice.fields.entry_date') }}*</label>
                                    <input type="text" class="form-control date-picker" name="entry_date" id="entry_date"  placeholder="Select a date"
                                        value="{{ old('entry_date', isset($invoice) ? $invoice->entry_date : '') }}" 
                                        required>
                                    
                                    @if($errors->has('entry_date'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('entry_date') }}
                                        </div>
                                    @endif
                                    <p class="helper-block">
                                        {{ trans('cruds.invoice.fields.entry_date_helper') }}
                                    </p>
                                </div>
                                <div class="form-group {{ $errors->has('invoice_number') ? 'has-error' : '' }}">
                                    <label for="invoice_number">{{ trans('cruds.invoice.fields.invoice_number') }}*</label>
                                    <input type="text" id="invoice_number" name="invoice_number" class="form-control" value="{{ old('invoice_number', isset($invoice) ? $invoice->invoice_number : '') }}" required>
                                    @if($errors->has('invoice_number'))
                                        <em class="invalid-feedback">
                                            {{ $errors->first('invoice_number') }}
                                        </em>
                                    @endif
                                    <p class="helper-block">
                                        {{ trans('cruds.invoice.fields.invoice_number_helper') }}
                                    </p>
                                </div>
                                <!-- Amount -->
                                <div class="form-group {{ $errors->has('original_amount') ? 'has-error' : '' }}">
                                    <label for="original_amount">{{ trans('cruds.invoice.fields.original_amount') }}*</label>
                                    <input type="text" id="original_amount" name="original_amount" class="form-control" value="{{ old('original_amount', isset($invoice) ? $invoice->original_amount : '') }}" placeholder="0.00" step="0.01" required  onkeyup="calDiscount();">
                                    @if($errors->has('original_amount'))
                                        <em class="invalid-feedback">
                                            {{ $errors->first('original_amount') }}
                                        </em>
                                    @endif
                                    <p class="helper-block">
                                        {{ trans('cruds.invoice.fields.original_amount_helper') }}
                                    </p>
                                </div>
                                <div class="form-group">
                                    <label for="discount_type">{{ trans('cruds.invoice.fields.discount_type') }}</label>
                                    <select name="discount_type" id="discount_type" class="form-control select2" onchange="showDiscountInput()">
                                        <option value="none" {{ (isset($invoice) && $invoice->discount_type == 'none') ? 'selected' : '' }}>None</option>
                                        <option value="percentage" {{ (isset($invoice) && $invoice->discount_type == 'percentage') ? 'selected' : '' }}>Percentage</option>
                                        <option value="fixed" {{ (isset($invoice) && $invoice->discount_type == 'fixed') ? 'selected' : '' }}>Fixed</option>
                                    </select>
                                </div>
                                <div class="form-group {{ $errors->has('discount') ? 'has-error' : '' }}" id='discount_div' style="display:none;">
                                    <label for="discount">{{ trans('cruds.invoice.fields.discount') }}*</label>
                                    <input type="text" id="discount" name="discount" class="form-control" value="{{ old('discount', isset($invoice) ? $invoice->discount : '') }}" onkeyup="calDiscount();">
                                    @if($errors->has('discount'))
                                        <em class="invalid-feedback">
                                            {{ $errors->first('discount') }}
                                        </em>
                                    @endif
                                    <p class="helper-block">
                                        {{ trans('cruds.invoice.fields.discount_helper') }}
                                    </p>
                                </div>
                                <div class="form-group {{ $errors->has('amount') ? 'has-error' : '' }}" id="amount_div" style="display:none;">
                                    <label for="amount">{{ trans('cruds.invoice.fields.amount') }}*</label>
                                    <input type="text" id="amount" name="amount" class="form-control" value="{{ old('amount', isset($invoice) ? $invoice->amount : '') }}" placeholder="0.00" step="0.01" required>
                                    @if($errors->has('amount'))
                                        <em class="invalid-feedback">
                                            {{ $errors->first('amount') }}
                                        </em>
                                    @endif
                                    <p class="helper-block">
                                        {{ trans('cruds.invoice.fields.amount_helper') }}
                                    </p>
                                </div>

                                <!-- Description -->
                                <div class="form-group {{ $errors->has('description') ? 'has-error' : '' }}">
                                    <label for="description">{{ trans('cruds.invoice.fields.description') }}</label>
                                    <textarea class="form-control h-150px" rows="6" id="description" name="description">{{ old('description', isset($invoice) ? $invoice->description : '') }}</textarea>
                                    @if($errors->has('description'))
                                        <em class="invalid-feedback">
                                            {{ $errors->first('description') }}
                                        </em>
                                    @endif
                                    <p class="helper-block">
                                        {{ trans('cruds.invoice.fields.description_helper') }}
                                    </p>
                                </div>

                                <!-- Image Upload -->
                                <div class="row row-xs align-items-center mg-b-20">
                                    <div class="col-md-4">
                                        <label class="mg-b-0">Image</label>
                                    </div>
                                    <div class="col-md-8 mg-t-5 mg-md-t-0">
                                    <input type="file" name="image" id="image" class="dropify"
                                        data-default-file="{{ isset($invoice->image) ? asset('storage/' . $invoice->image) : '' }}"
                                        data-height="200" accept=".jpg, .png, image/jpeg, image/png"
                                        {{ isset($invoice->image) ? '' : 'required' }}>
                                </div>

                                <!-- <div class="row row-xs align-items-center mg-b-20">
                                    <div class="col-md-4">
                                        <label class="mg-b-0"> Take A Photo</label>
                                    </div>
                                    <div class="col-md-8 mg-t-5 mg-md-t-0">
                                        <div class="d-flex align-items-center">
                                          
                                            <input type="file" name="camera_image" id="camera_image" accept="image/*" capture="camera" 
                                                style="display: none;" onchange="handleCameraCapture(this)">
                                            
                                            
                                            <button type="button" class="btn btn-light btn-icon" onclick="document.getElementById('camera_image').click()">
                                                <i class="fa fa-camera"></i>
                                            </button>

                                           
                                            <input type="file" name="camera_image" id="camera_image"
                                              data-default-file="{{ isset($invoice->camera_image) ? asset('storage/' . $invoice->camera_image) : '' }}"
                                                class="dropify ml-3" data-height="200"
                                                accept=".jpg, .png, image/jpeg, image/png">
                                        </div>
                                    </div>
                                </div> -->
                            </div>

                                <!-- Submit Button -->
                                <div>
                                    <input class="btn btn-danger me-3" type="submit" value="{{ trans('global.save') }}">
                                    <a href="{{ url()->previous() }}" class="btn btn-secondary">
                                        {{ trans('global.cancel') }}
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Internal Fileuploads js-->
<script src="{{asset('plugins/fileuploads/js/fileupload.js')}}"></script>
<script src="{{asset('plugins/fileuploads/js/file-upload.js')}}"></script>

<!-- Flatpickr JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
    flatpickr("#entry_date", {
        dateFormat: "Y-m-d", // Adjust as needed
        allowInput: true
    });
});
</script>

<script>
//     function handleCameraCapture(input) {
//     if (navigator.userAgent.match(/Android|iPhone|iPad|iPod/i)) {
//         // Mobile device: Display camera functionality
//         if (input.files && input.files[0]) {
//             const reader = new FileReader();
//             reader.onload = function (e) {
//                 // For previewing the captured image (optional)
//                 const preview = document.createElement('img');
//                 preview.src = e.target.result;
//                 preview.style.maxWidth = '100%';
//                 preview.style.marginTop = '10px';
//                 input.parentElement.appendChild(preview);
//             };
//             reader.readAsDataURL(input.files[0]);
//         }
//     } else {
//         // Desktop device: Open file picker
//         alert('This device does not support direct camera capture. Please select an image file.');
//     }
// }

function showDiscountInput(){
    var discountType = $('#discount_type').val();
    if(discountType != 'none'){
        $("#discount_div").show();
        $("#amount_div").show();
        calDiscount();
    }else{
        $("#discount_div").hide();
        $("#amount_div").hide();
        $("#discount").val(0);
        $("#amount").val($("#original_amount").val());
    }
}
function calDiscount(){
    var discountType = $('#discount_type').val();
    var discount = $('#discount').val();
    var originalAmount = $("#original_amount").val();
    if(discountType == 'percentage'){
        $("#amount").val(originalAmount-(originalAmount*(discount/100)));
    }else if(discountType == 'fixed'){
        $("#amount").val(originalAmount-discount);
    }

}
$(document).ready(function () {
    var discountType = $('#discount_type').val();
    if(discountType != 'none'){
        $("#discount_div").show();
        $("#amount_div").show();
    }else{
        $("#discount_div").hide();
        $("#amount_div").hide();
    }
    $('#amount').on('blur', function () {
        var value = parseFloat($(this).val());
        if (!isNaN(value)) {
            $(this).val(value.toFixed(2)); // Format with two decimal places
        } else {
            $(this).val(''); // Clear input if invalid
        }
    });
    $('#amount').on('blur', function () {
        var value = parseFloat($(this).val());
        if (!isNaN(value)) {
            $(this).val(value.toFixed(2)); // Format with two decimal places
        } else {
            $(this).val(''); // Clear input if invalid
        }
    });
});
</script>

@endsection
