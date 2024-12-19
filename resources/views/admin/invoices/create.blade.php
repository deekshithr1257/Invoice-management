@extends('layouts.admin')
@section('content')

<link href="{{asset('plugins/fileuploads/css/fileupload.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('plugins/fancyuploder/fancy_fileupload.css')}}" rel="stylesheet" />


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
                                <div class="form-group {{ $errors->has('invoice_category_id') ? 'has-error' : '' }}">
                                    <label for="invoice_category">{{ trans('cruds.invoice.fields.invoice_category') }}</label>
                                    <select name="invoice_category_id" id="invoice_category" class="form-control select2">
                                        @foreach($invoice_categories as $id => $invoice_category)
                                            <option value="{{ $id }}" {{ (isset($invoice) && $invoice->invoice_category ? $invoice->invoice_category->id : old('invoice_category_id')) == $id ? 'selected' : '' }}>{{ $invoice_category }}</option>
                                        @endforeach
                                    </select>
                                    @if($errors->has('invoice_category_id'))
                                        <em class="invalid-feedback">
                                            {{ $errors->first('invoice_category_id') }}
                                        </em>
                                    @endif
                                </div>
                                
                                <div class="form-group {{ $errors->has('entry_date') ? 'has-error' : '' }}">
                                            <label for="entry_date">{{ trans('cruds.invoice.fields.entry_date') }}*</label>
                                            <input type="date" class="form-control date" name="entry_date" id="entry_date" 
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
                        </div>
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


<script src="{{asset('plugins/fileuploads/js/fileupload.js')}}"></script>
    <script src="{{asset('plugins/fileuploads/js/file-upload.js')}}"></script>
@endsection