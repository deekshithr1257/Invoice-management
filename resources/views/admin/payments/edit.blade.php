@extends('layouts.admin')
@section('content')

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

<div class="content-body">
    <div class="row page-titles mx-0">
        <div class="col p-md-0">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.payments.index') }}">{{ trans('cruds.payment.title_singular') }}</a></li>
                <li class="breadcrumb-item active">{{ trans('global.edit') }} {{ trans('cruds.payment.title_singular') }}</li>
            </ol>
        </div>
    </div>

    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                {{ trans('global.edit') }} {{ trans('cruds.payment.title_singular') }}
            </div>

            <div class="card-body">
                <form action="{{ route('admin.payments.update', [$payment->id]) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="invoice_id" name="invoice_id" value="{{ $payment->invoice_id }}">
                    <div class="form-group {{ $errors->has('payment_type_id') ? 'has-error' : '' }}">
                        <label for="payment_type">{{ trans('cruds.payment.fields.payment_type') }}</label>
                        <select name="payment_type_id" id="payment_type" class="form-control select2">
                            @foreach($payment_types as $id => $payment_type)
                                <option value="{{ $id }}" {{ (isset($payment) && $payment->payment_type ? $payment->payment_type->id : old('payment_type_id')) == $id ? 'selected' : '' }}>{{ $payment_type }}</option>
                            @endforeach
                        </select>
                        @if($errors->has('payment_type_id'))
                            <em class="invalid-feedback">
                                {{ $errors->first('payment_type_id') }}
                            </em>
                        @endif
                    </div>

                    <div class="form-group {{ $errors->has('entry_date') ? 'has-error' : '' }}">
                        <label for="entry_date">{{ trans('cruds.payment.fields.entry_date') }}*</label>
                        <input type="text" id="entry_date" name="entry_date" class="form-control date-picker" value="{{ old('entry_date', isset($payment) ? $payment->entry_date : '') }}" placeholder="Select a date" required>
                        @if($errors->has('entry_date'))
                            <em class="invalid-feedback">
                                {{ $errors->first('entry_date') }}
                            </em>
                        @endif
                        <p class="helper-block">
                            {{ trans('cruds.payment.fields.entry_date_helper') }}
                        </p>
                    </div>


                    <div class="form-group {{ $errors->has('amount') ? 'has-error' : '' }}">
                        <label for="amount">{{ trans('cruds.payment.fields.amount') }}*</label>
                        <input type="number" id="amount" name="amount" class="form-control" value="{{ old('amount', isset($payment) ? $payment->amount : '') }}" step="0.01" required>
                        @if($errors->has('amount'))
                            <em class="invalid-feedback">
                                {{ $errors->first('amount') }}
                            </em>
                        @endif
                        <p class="helper-block">
                            {{ trans('cruds.payment.fields.amount_helper') }}
                        </p>
                    </div>

                    <div class="form-group {{ $errors->has('description') ? 'has-error' : '' }}">
                        <label for="description">{{ trans('cruds.payment.fields.description') }}</label>
                        <input type="text" id="description" name="description" class="form-control" value="{{ old('description', isset($payment) ? $payment->description : '') }}">
                        @if($errors->has('description'))
                            <em class="invalid-feedback">
                                {{ $errors->first('description') }}
                            </em>
                        @endif
                        <p class="helper-block">
                            {{ trans('cruds.payment.fields.description_helper') }}
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

<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
    flatpickr("#entry_date", {
        dateFormat: "Y-m-d", // Adjust as needed
        allowInput: true
    });
});
</script>

@endsection
