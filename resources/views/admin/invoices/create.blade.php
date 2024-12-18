@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.invoice.title_singular') }}
    </div>

    <div class="card-body">
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
                <input type="text" id="description" name="description" class="form-control" value="{{ old('description', isset($invoice) ? $invoice->description : '') }}">
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
@endsection