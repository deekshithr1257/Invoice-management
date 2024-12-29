@extends('layouts.admin')
@section('content')

<link href="{{asset('plugins/fileuploads/css/fileupload.css')}}" rel="stylesheet" type="text/css" />
<!-- <link href="{{asset('plugins/fancyuploder/fancy_fileupload.css')}}" rel="stylesheet" /> -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">


<div class="content-body">
    <div class="row page-titles mx-0">
        <div class="col p-md-0">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="javascript:void(0)">Invoice</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Add</a></li>
            </ol>
        </div>
    </div>
    <!-- row -->

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">{{ trans('global.create') }} {{ trans('cruds.invoice.title_singular') }}</h4>
                        <div class="basic-form">
                            <form action="{{ route("admin.invoices.store") }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="created_by" id="created_by" value="{{ auth()->id() }}">
                                <div class="form-group {{ $errors->has('supplier_id') ? 'has-error' : '' }}">
                                    <label for="suppliers">{{ trans('cruds.invoice.fields.supplier') }}</label>
                                    <select name="supplier_id" id="supplier_id" class="form-control select2">
                                        @foreach($suppliers as $id => $suppliers)
                                            <option value="{{ $id }}" {{ (isset($invoice) && $invoice->suppliers ? $invoice->suppliers->id : old('supplier_id')) == $id ? 'selected' : '' }}>{{ $suppliers }}</option>
                                        @endforeach
                                    </select>
                                    @if($errors->has('supplier_id'))
                                        <em class="invalid-feedback">
                                            {{ $errors->first('supplier_id') }}
                                        </em>
                                    @endif
                                </div>
                                
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
                                <div class="form-group {{ $errors->has('amount') ? 'has-error' : '' }}">
                                    <label for="amount">{{ trans('cruds.invoice.fields.amount') }}*</label>
                                    <input type="number" id="amount" name="amount" class="form-control" value="{{ old('amount', isset($invoice) ? $invoice->amount : '') }}" step="0.01" required>
                                    @if($errors->has('amount'))
                                        <em class="invalid-feedback">
                                            {{ $errors->first('amount') }}
                                        </em>
                                    @endif
                                    <p class="helper-block">
                                        {{ trans('cruds.invoice.fields.amount_helper') }}
                                    </p>
                                </div>
                                <div class="form-group {{ $errors->has('description') ? 'has-error' : '' }}">
                                    <label for="description">{{ trans('cruds.invoice.fields.description') }}</label>
                                    <textarea class="form-control h-150px" rows="6" id="comment" id="description" name="description" >{{ old('description', isset($invoice) ? $invoice->description : '') }}</textarea>
                                    @if($errors->has('description'))
                                        <em class="invalid-feedback">
                                            {{ $errors->first('description') }}
                                        </em>
                                    @endif
                                    <p class="helper-block">
                                        {{ trans('cruds.invoice.fields.description_helper') }}
                                    </p>
                                </div>
                                <div class="row row-xs align-items-center mg-b-20">
                            <div class="col-md-4">
                                <label class="mg-b-0"> Image</label>
                            </div>
                            <div class="col-md-8 mg-t-5 mg-md-t-0">
                                <input type="file" name="image" id="image"
                                    class="dropify" data-height="200"
                                    accept=".jpg, .png, image/jpeg, image/png" required>
                            </div>

                                <div class="row row-xs align-items-center mg-b-20">
                                    <div class="col-md-8">
                                        <label class="mg-b-0"> Take a Photo</label>
                                    </div>
                                    <div class="col-md-4 mg-t-5 mg-md-t-0">
                                        <div class="d-flex align-items-center">
                                            <!-- Camera Input -->
                                            <input type="file" name="camera_image" id="camera_image" accept="image/*" capture="camera" 
                                                style="display: none;" onchange="handleCameraCapture(this)">
                                            
                                            <!-- Camera Icon -->
                                            <button type="button" class="btn btn-light btn-icon" onclick="document.getElementById('camera_image').click()">
                                                <i class="fa fa-camera"></i>
                                            </button>

                                            <!-- Existing File Input -->
                                            <!-- <input type="file" name="camera_image" id="camera_image"
                                                class="dropify ml-3" data-height="200"
                                                accept=".jpg, .png, image/jpeg, image/png"> -->
                                        </div>
                                    </div>
                                </div>
                                </div>
                                <br>
                                <div>
                                    <input class="btn btn-danger" type="submit" value="{{ trans('global.save') }}">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Internal Fileuploads js-->

<!-- Include jQuery first (Make sure this is included before any other JS files that depend on jQuery) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

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
    function handleCameraCapture(input) {
    if (navigator.userAgent.match(/Android|iPhone|iPad|iPod/i)) {
        // Mobile device: Display camera functionality
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function (e) {
                // For previewing the captured image (optional)
                const preview = document.createElement('img');
                preview.src = e.target.result;
                preview.style.maxWidth = '100%';
                preview.style.marginTop = '10px';
                input.parentElement.appendChild(preview);
            };
            reader.readAsDataURL(input.files[0]);
        }
    } else {
        // Desktop device: Open file picker
        alert('This device does not support direct camera capture. Please select an image file.');
    }
}
</script>
@endsection