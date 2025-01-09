@extends('layouts.admin')
@section('content')

<link href="{{asset('plugins/fileuploads/css/fileupload.css')}}" rel="stylesheet" type="text/css" />
<!-- <link href="{{asset('plugins/fancyuploder/fancy_fileupload.css')}}" rel="stylesheet" /> -->
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
                                <div class="row row-xs align-items-center mg-b-20" id="desktop-file-upload">
                                    <div class="col-md-4">
                                        <label class="mg-b-0"> {{ trans('cruds.invoice.fields.invoice') }}</label>
                                    </div>
                                    <div class="col-md-8 mg-t-5 mg-md-t-0">
                                        <!-- File input for new images -->
                                        <div class="custom-file text-center dz-clickable">
                                            <input type="file" name="image_files[]" class="custom-file-input" id="galleryImagesButton" multiple="multiple">
                                        </div>

                                        <!-- Existing image previews -->
                                        <div id="existingImagePreviews" class="user-image mb-3 text-center mt-3">
                                            @foreach ($invoice->images as $image)
                                                <div class="imgPreview" data-id="{{ $image->id }}">
                                                    <a class="delete-existing" data-id="{{ $image->id }}">
                                                        <img class="images" src="{{ asset('storage/' . $image->image_path) }}" alt="Preview">
                                                        <i class="ri-close-circle-fill" aria-hidden="true" id="closebtn"></i>
                                                    </a>
                                                    <input type="hidden" name="existing_images[]" value="{{ $image->id }}">
                                                </div>
                                            @endforeach
                                        </div>

                                        <!-- New image previews -->
                                        <div id="imagePreviews" class="user-image mb-3 text-center mt-3"></div>

                                        @if($errors->has('image_files'))
                                            <em class="invalid-feedback">
                                                {{ $errors->first('image_files') }}
                                            </em>
                                        @endif
                                    </div>
                                </div>


                                <!-- Mobile Camera Capture -->
                                <div class="row row-xs align-items-center mg-b-20" id="mobile-camera-upload" style="display: none;">
                                    <div class="col-md-4">
                                        <label class="mg-b-0">Capture Images</label>
                                    </div>
                                    <div class="col-md-8 mg-t-5 mg-md-t-0">
                                        <!-- Camera input for new images -->
                                        <!-- Camera icon to open the camera -->
                                        <button type="button" class="btn btn-light btn-icon" id="cameraIconButton">
                                            <i class="fa fa-camera"></i>
                                        </button>

                                        <!-- Camera input (hidden) -->
                                        <input 
                                            type="file" 
                                            name="camera_images[]" 
                                            class="custom-file-input d-none" 
                                            id="mobileCaptureButton" 
                                            accept="image/*" 
                                            capture="camera" 
                                            multiple
                                        >

                                        <!-- Existing image previews -->
                                        <div id="existingMobileImagePreviews" class="user-image mb-3 text-center mt-3">
                                            @foreach ($invoice->images as $image)
                                                <div class="imgPreview" data-id="{{ $image->id }}">
                                                    <a class="delete-existing" data-id="{{ $image->id }}">
                                                        <img class="images" src="{{ asset('storage/' . $image->image_path) }}" alt="Preview">
                                                        <i class="ri-close-circle-fill" aria-hidden="true" id="closebtn"></i>
                                                    </a>
                                                    <input type="hidden" name="existing_images[]" value="{{ $image->id }}">
                                                </div>
                                            @endforeach
                                        </div>

                                        <!-- New image previews -->
                                        <div id="mobileImagePreviews" class="user-image mb-3 text-center mt-3"></div>

                                        @if($errors->has('camera_images'))
                                            <em class="invalid-feedback">
                                                {{ $errors->first('camera_images') }}
                                            </em>
                                        @endif
                                    </div>
                                </div>



                            </div>

                                <!-- Submit Button -->
                                <div>
                                <input 
                                    id="editButton" 
                                    class="btn btn-danger me-3" 
                                    type="submit" 
                                    value="{{ trans('global.save') }}" 
                                    onclick="handleEditSubmit(event)">
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
<style>
#imagePreviews {
    display: flex;
    flex-wrap: wrap;
    gap: 10px; /* Space between images */
    justify-content: center; /* Optional: Centers the images horizontally */
}
    .imgPreview img {
    padding: 8px;
    max-width: 100px;
}
#existingImagePreviews {
    display: flex;
    flex-wrap: wrap;
    gap: 10px; /* Space between images */
    justify-content: center; /* Optional: Centers the images horizontally */
}
    .existingImagePreviews img {
    padding: 8px;
    max-width: 100px;
}

.delete {
    padding: 40px 0px;
    margin-right: 10px;
    margin-bottom: 10px;
}
#galleryImagesButton {
    display: table-header-group;
    width: 100%;
    padding: 146px 0 0px 0;
    height: 2px;
    -webkit-box-sizing: border-box;
    -moz-box-sizing: border-box;
    align-items: center;
    box-sizing: border-box;
    background: url('{{ asset('images/cloud-upload.png') }}') 235px 13px no-repeat;
    border-radius: 20px;
    border: 2px dashed var(--vz-border-color);
    border-radius: 6px;
    cursor: pointer;
}
.custom-file-input {
    opacity: unset;
}
#closebtn {
    position: relative;
    top: -27px;
}
@media (max-width: 768px) {
    #galleryImagesButton {
        background: url('{{ asset('images/cloud-upload.png') }}') 10px 13px no-repeat; /* Adjusted position for smaller screens */
        padding: 100px 0 0 0; /* Reduced padding for mobile */
    }
}
 </style>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Internal Fileuploads js-->
<!-- <script src="{{asset('plugins/fileuploads/js/fileupload.js')}}"></script>
<script src="{{asset('plugins/fileuploads/js/file-upload.js')}}"></script> -->

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
   // Function to detect if the device is mobile
   function isMobile() {
    return /Mobi|Android/i.test(navigator.userAgent);
}
$(document).ready(function () {
    if (isMobile()) {
        // Remove the file upload section if mobile
        $('#desktop-file-upload').remove();
        return; // Exit further execution for file upload functionality
    }
    let filesArray = []; // Array to manage the selected files
    let deletedImages = []; // Array to track deleted existing images

    // Handle new image uploads
    $('#galleryImagesButton').on('change', function (e) {
        const files = e.target.files;
        const imagePreviews = $('#imagePreviews');

        // Add new files to the array
        for (let i = 0; i < files.length; i++) {
            filesArray.push(files[i]);
        }

        // Clear previous previews and regenerate them
        imagePreviews.empty();
        filesArray.forEach((file, index) => {
            const reader = new FileReader();
            reader.onload = function (e) {
                const imageUrl = e.target.result;

                // Create image preview with delete button
                const previewHtml = `
                    <div class="imgPreview" data-index="${index}">
                        <a class="delete-new" data-value="${index}">
                            <img class="images" src="${imageUrl}" alt="Preview">
                            <i class="ri-close-circle-fill" aria-hidden="true" id="closebtn"></i>
                        </a>
                    </div>
                `;
                imagePreviews.append(previewHtml);
            };
            reader.readAsDataURL(file);
        });

        // Update the FileList in the input field
        const dataTransfer = new DataTransfer();
        filesArray.forEach(file => dataTransfer.items.add(file));
        $('#galleryImagesButton')[0].files = dataTransfer.files;
    });

    // Handle deletion of new images
    $('#imagePreviews').on('click', '.delete-new', function () {
        const index = $(this).data('value');
        filesArray.splice(index, 1);

        // Clear previews and regenerate with updated array
        const imagePreviews = $('#imagePreviews');
        imagePreviews.empty();
        filesArray.forEach((file, index) => {
            const reader = new FileReader();
            reader.onload = function (e) {
                const imageUrl = e.target.result;

                // Create image preview with delete button
                const previewHtml = `
                    <div class="imgPreview" data-index="${index}">
                        <a class="delete-new" data-value="${index}">
                            <img class="images" src="${imageUrl}" alt="Preview">
                            <i class="ri-close-circle-fill" aria-hidden="true" id="closebtn"></i>
                        </a>
                    </div>
                `;
                imagePreviews.append(previewHtml);
            };
            reader.readAsDataURL(file);
        });

        const dataTransfer = new DataTransfer();
        filesArray.forEach(file => dataTransfer.items.add(file));
        $('#galleryImagesButton')[0].files = dataTransfer.files;
    });

    // Handle deletion of existing images
    $('#existingImagePreviews').on('click', '.delete-existing', function () {
        const imageId = $(this).data('id');

        // Remove the image preview
        $(this).closest('.imgPreview').remove();

        // Add image ID to the deleted images array
        deletedImages.push(imageId);

        // Add deleted images array to a hidden input for form submission
        $('form').append(`<input type="hidden" name="deleted_images[]" value="${imageId}">`);
    });

    console.log('Deleted images:', deletedImages);
});


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

<script>
   // Function to detect if the device is mobile
function isMobile() {
    return /Mobi|Android/i.test(navigator.userAgent);
}

$(document).ready(function () {
    if (isMobile()) {
        // Display the mobile camera capture section and hide desktop upload
        $('#mobile-camera-upload').show();
        $('#desktop-file-upload').remove();
    } else {
        // Display the desktop file upload section and hide mobile capture
        $('#desktop-file-upload').show();
        $('#mobile-camera-upload').remove();
    }

    let mobileFilesArray = []; // Array to manage mobile captured files
    let deletedImages = []; // Array to track deleted existing images

      // Trigger the file input when the camera icon is clicked
      $('#cameraIconButton').on('click', function () {
        $('#mobileCaptureButton').click();
    });

    // Handle new mobile camera captures
    $('#mobileCaptureButton').on('change', function (e) {
        const files = e.target.files;
        const mobileImagePreviews = $('#mobileImagePreviews');

        // Add new files to the array
        for (let i = 0; i < files.length; i++) {
            mobileFilesArray.push(files[i]);
        }

        // Clear previous previews and regenerate them
        mobileImagePreviews.empty();
        mobileFilesArray.forEach((file, index) => {
            const reader = new FileReader();
            reader.onload = function (e) {
                const imageUrl = e.target.result;

                // Create image preview with delete button
                const previewHtml = `
                    <div class="imgPreview" data-index="${index}">
                        <a class="delete-new" data-value="${index}">
                            <img class="images" src="${imageUrl}" alt="Preview">
                            <i class="ri-close-circle-fill" aria-hidden="true" id="closebtn"></i>
                        </a>
                    </div>
                `;
                mobileImagePreviews.append(previewHtml);
            };
            reader.readAsDataURL(file);
        });

        // Update the FileList in the input field
        const dataTransfer = new DataTransfer();
        mobileFilesArray.forEach(file => dataTransfer.items.add(file));
        $('#mobileCaptureButton')[0].files = dataTransfer.files;
    });

    // Handle deletion of new mobile images
    $('#mobileImagePreviews').on('click', '.delete-new', function () {
        const index = $(this).data('value');
        mobileFilesArray.splice(index, 1);

        // Clear previews and regenerate with updated array
        const mobileImagePreviews = $('#mobileImagePreviews');
        mobileImagePreviews.empty();
        mobileFilesArray.forEach((file, index) => {
            const reader = new FileReader();
            reader.onload = function (e) {
                const imageUrl = e.target.result;

                // Create image preview with delete button
                const previewHtml = `
                    <div class="imgPreview" data-index="${index}">
                        <a class="delete-new" data-value="${index}">
                            <img class="images" src="${imageUrl}" alt="Preview">
                            <i class="ri-close-circle-fill" aria-hidden="true" id="closebtn"></i>
                        </a>
                    </div>
                `;
                mobileImagePreviews.append(previewHtml);
            };
            reader.readAsDataURL(file);
        });

        const dataTransfer = new DataTransfer();
        mobileFilesArray.forEach(file => dataTransfer.items.add(file));
        $('#mobileCaptureButton')[0].files = dataTransfer.files;
    });

    // Handle deletion of existing images
    $('#existingMobileImagePreviews, #existingImagePreviews').on('click', '.delete-existing', function () {
        const imageId = $(this).data('id');

        // Remove the image preview
        $(this).closest('.imgPreview').remove();

        // Add image ID to the deleted images array
        deletedImages.push(imageId);

        // Add deleted images array to a hidden input for form submission
        $('form').append(`<input type="hidden" name="deleted_images[]" value="${imageId}">`);
    });

    console.log('Deleted images:', deletedImages);
});

</script>
<script>
    function handleEditSubmit(event) {
    console.log("Edit form submit function triggered."); // Debug log

    event.preventDefault(); // Prevent default submission temporarily

    const editButton = document.getElementById('editButton');
    if (!editButton) {
        console.error("Edit button not found.");
        return;
    }

    console.log("Edit button found. Updating its state.");
    // Disable the button and change its text
    editButton.disabled = true;
    editButton.value = "Submitting...";

    // Use the form associated with the event target
    const form = event.target.form; 
    if (!form) {
        console.error("Form not found.");
        return;
    }

    console.log("Edit form is being submitted.");
    form.submit();
}

</script>

@endsection
