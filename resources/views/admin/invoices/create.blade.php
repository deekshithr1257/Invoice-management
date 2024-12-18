@extends('layouts.admin')
@section('content')
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
                                    <input type="text" id="entry_date" name="entry_date" class="form-control date" value="{{ old('entry_date', isset($invoice) ? $invoice->entry_date : '') }}" required>
                                    <div class="example">
                                        <h5 class="box-title m-t-30">Autoclose Datedpicker</h5>
                                        <p class="text-muted m-b-20">just add class <code>.complex-colorpicker</code> to create it.</p>
                                       
                                    </div>
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="datepicker-autoclose" placeholder="mm/dd/yyyy"> <span class="input-group-append"><span class="input-group-text"><i class="mdi mdi-calendar-check"></i></span></span>
                                    </div>
                                    @if($errors->has('entry_date'))
                                        <em class="invalid-feedback">
                                            {{ $errors->first('entry_date') }}
                                        </em>
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
@endsection