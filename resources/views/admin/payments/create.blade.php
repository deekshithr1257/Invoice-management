@extends('layouts.admin')
@section('content')

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

<div class="content-body">
    <!-- <div class="row page-titles mx-0">
        <div class="col p-md-0">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.payments.index') }}">{{ trans('cruds.payment.title_singular') }}</a></li>
                <li class="breadcrumb-item active">{{ trans('global.create') }} {{ trans('cruds.payment.title_singular') }}</li>
            </ol>
        </div>
    </div> -->

    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                {{ trans('global.create') }} {{ trans('cruds.payment.title_singular') }}
            </div>

            <div class="card-body">
                <form action="{{ route('admin.payments.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="created_by" id="created_by" value="{{ auth()->id() }}">
                    <input type="hidden" name="store_id" id="store_id" value="{{ $store_id }}">
                    <div class="form-group {{ $errors->has('invoice_id') ? 'has-error' : '' }}">
                        <label for="invoice_id">{{ trans('cruds.payment.fields.invoice_number') }}</label>
                        <select name="invoice_id" id="invoice_id" class="form-control select2" onchange="getBalance(this.value);">
                            @foreach($invoices as $id => $invoice)
                                <option value="{{ $id }}" {{ old('invoice_id') == $id ? 'selected' : '' }}>{{ $invoice }}</option>
                            @endforeach
                        </select>
                        @if($errors->has('invoice_id'))
                            <em class="invalid-feedback">
                                {{ $errors->first('invoice_id') }}
                            </em>
                        @endif
                        <p class="helper-block">
                            {{ trans('cruds.payment.fields.invoice_number_helper') }}
                        </p>
                    </div>
                    <div class="form-group {{ $errors->has('payment_type_id') ? 'has-error' : '' }}">
                        <label for="payment_type">{{ trans('cruds.payment.fields.payment_type') }}</label>
                        <select name="payment_type_id" id="payment_type" class="form-control select2">
                            @foreach($payment_types as $id => $payment_type)
                                <option value="{{ $id }}" {{ old('payment_type_id') == $id ? 'selected' : '' }}>{{ $payment_type }}</option>
                            @endforeach
                        </select>
                        @if($errors->has('payment_type_id'))
                            <em class="invalid-feedback">
                                {{ $errors->first('payment_type_id') }}
                            </em>
                        @endif
                        <p class="helper-block">
                            {{ trans('cruds.payment.fields.payment_type_helper') }}
                        </p>
                    </div>

                    <div class="form-group {{ $errors->has('entry_date') ? 'has-error' : '' }}">
                        <label for="entry_date">{{ trans('cruds.payment.fields.entry_date') }}*</label>
                        <input type="text" id="entry_date" name="entry_date" class="form-control date-picker" value="{{ old('entry_date') }}" placeholder="Select a date" required>
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
                        <input type="number" id="amount" name="amount" class="form-control" value="{{ old('amount') }}" step="0.01" required>
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
                        <textarea class="form-control h-150px" rows="6" id="description" name="description" >{{ old('description', isset($payment) ? $payment->description : '') }}</textarea>
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
                        <a href="{{ url()->previous() }}" class="btn btn-secondary">
                                        {{ trans('global.cancel') }}
                                    </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
    
    $(document).ready(function () {
        // Initialize Select2
        $('#invoice_id').select2({
            allowClear: true, // Allow clearing
            width: 'resolve', // Adjust dropdown width
        });
    });
    document.addEventListener('DOMContentLoaded', function() {
        flatpickr("#entry_date", {
            dateFormat: "d-m-Y", // Adjust as needed
            allowInput: true
        });
    });

    function getBalance(invoiceId){
        if (!invoiceId) {
            alert('Please provide a valid invoice ID.');
            return;
        }
        const url = "{{ route('admin.invoices.balance', ['id' => ':id']) }}".replace(':id', invoiceId);
        $.ajax({
            url: url,
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response.balance !== undefined) {
                    $('#amount').val(response.balance);
                } else {
                    alert('Unable to fetch the balance.');
                }
            },
            error: function(xhr) {
                alert(`Error: ${xhr.responseJSON?.error || 'Something went wrong.'}`);
            }
        });
    }
</script>

@endsection
