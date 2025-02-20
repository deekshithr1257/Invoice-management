@extends('layouts.admin')
@section('content')

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

<div class="content-body">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                {{ trans('global.edit') }} {{ trans('cruds.sales.title_singular') }}
            </div>

            <div class="card-body">
                <form action="{{ route('admin.sales.update', [$sale->id]) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="store_id" id="store_id" value="{{ $store_id }}">

                    <div class="form-group {{ $errors->has('entry_date') ? 'has-error' : '' }}">
                        <label for="entry_date">{{ trans('cruds.sales.fields.entry_date') }}*</label>
                        <input type="text" id="entry_date" name="entry_date" class="form-control date-picker" value="{{ old('entry_date', isset($sale) ? $sale->entry_date : '') }}" placeholder="Select a date" required>
                        @if($errors->has('entry_date'))
                            <em class="invalid-feedback">
                                {{ $errors->first('entry_date') }}
                            </em>
                        @endif
                        <p class="helper-block">
                            {{ trans('cruds.sales.fields.entry_date_helper') }}
                        </p>
                    </div>
                    @if($sale->pay_out_admin == 0)
                        <div class="form-group {{ $errors->has('cash') ? 'has-error' : '' }}">
                            <label for="cash">{{ trans('cruds.sales.fields.cash') }}*</label>
                            <input type="number" id="cash" name="cash" class="form-control" value="{{ old('cash', isset($sale) ? $sale->cash : '') }}" step="0.01" required onkeyup="calCashBalance();">
                            @if($errors->has('cash'))
                                <em class="invalid-feedback">
                                    {{ $errors->first('cash') }}
                                </em>
                            @endif
                            <p class="helper-block">
                                {{ trans('cruds.sales.fields.cash_helper') }}
                            </p>
                        </div>

                        <div class="form-group {{ $errors->has('pay_out') ? 'has-error' : '' }}">
                            <label for="pay_out">{{ trans('cruds.sales.fields.pay_out') }}*</label>
                            <input type="number" id="pay_out" name="pay_out" class="form-control" value="{{ old('pay_out', isset($sale) ? $sale->pay_out : '') }}" step="0.01" required onkeyup="calCashBalance();">
                            @if($errors->has('pay_out'))
                                <em class="invalid-feedback">
                                    {{ $errors->first('pay_out') }}
                                </em>
                            @endif
                            <p class="helper-block">
                                {{ trans('cruds.sales.fields.pay_out_helper') }}
                            </p>
                        </div>

                        <div class="form-group {{ $errors->has('cash_balance') ? 'has-error' : '' }}">
                            <label for="cash_balance">{{ trans('cruds.sales.fields.cash_balance') }}*</label>
                            <input type="number" id="cash_balance" name="cash_balance" class="form-control" value="{{ old('cash_balance', isset($sale) ? $sale->cash_balance : '') }}" step="0.01" required readonly>
                            @if($errors->has('cash_balance'))
                                <em class="invalid-feedback">
                                    {{ $errors->first('cash_balance') }}
                                </em>
                            @endif
                            <p class="helper-block">
                                {{ trans('cruds.sales.fields.cash_balance_helper') }}
                            </p>
                        </div>

                        <div class="form-group {{ $errors->has('card') ? 'has-error' : '' }}">
                            <label for="card">{{ trans('cruds.sales.fields.card') }}*</label>
                            <input type="number" id="card" name="card" class="form-control" value="{{ old('card', isset($sale) ? $sale->card : '') }}" step="0.01" required>
                            @if($errors->has('card'))
                                <em class="invalid-feedback">
                                    {{ $errors->first('card') }}
                                </em>
                            @endif
                            <p class="helper-block">
                                {{ trans('cruds.sales.fields.card_helper') }}
                            </p>
                        </div>
                    @else
                        <div class="form-group {{ $errors->has('pay_out_admin') ? 'has-error' : '' }}">
                            <label for="pay_out_admin">{{ trans('cruds.sales.fields.pay_out_admin') }}*</label>
                            <input type="number" id="pay_out_admin" name="pay_out_admin" class="form-control" value="{{ old('pay_out_admin', isset($sale) ? $sale->pay_out_admin : '') }}" step="0.01" required>
                            @if($errors->has('pay_out_admin'))
                                <em class="invalid-feedback">
                                    {{ $errors->first('pay_out_admin') }}
                                </em>
                            @endif
                            <p class="helper-block">
                                {{ trans('cruds.sales.fields.pay_out_helper') }}
                            </p>
                        </div>
                    @endif
                    <div class="form-group {{ $errors->has('description') ? 'has-error' : '' }}">
                        <label for="description">{{ trans('cruds.sales.fields.description') }}</label>
                        <textarea class="form-control h-150px" rows="6" id="description" name="description" >{{ old('description', isset($sale) ? $sale->description : '') }}</textarea>
                        @if($errors->has('description'))
                            <em class="invalid-feedback">
                                {{ $errors->first('description') }}
                            </em>
                        @endif
                        <p class="helper-block">
                            {{ trans('cruds.sales.fields.description_helper') }}
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
    document.addEventListener('DOMContentLoaded', function() {
        flatpickr("#entry_date", {
            dateFormat: "d-m-Y", // Adjust as needed
            allowInput: true
        });
    });
    $(document).ready(function () {
        $('#cash').on('blur', function () {
            var value = parseFloat($(this).val());
            if (!isNaN(value)) {
                $(this).val(value.toFixed(2));
            } else {
                $(this).val('');
            }
        });
        $('#pay_out_admin').on('blur', function () {
            var value = parseFloat($(this).val());
            if (!isNaN(value)) {
                $(this).val(value.toFixed(2));
            } else {
                $(this).val('');
            }
        });
        $('#pay_out').on('blur', function () {
            var value = parseFloat($(this).val());
            if (!isNaN(value)) {
                $(this).val(value.toFixed(2));
            } else {
                $(this).val('');
            }
        });
        $('#pay_out').on('input', function () {
            const cash = parseFloat($('#cash').val()) || 0;
            const payOut = parseFloat($(this).val()) || 0;

            // Check if pay_out exceeds cash
            if (payOut > cash) {
                alert('Pay Out must not exceed Cash!');
                $(this).val(cash); // Reset pay_out to cash value
            }
        });
        $('#card').on('blur', function () {
            var value = parseFloat($(this).val());
            if (!isNaN(value)) {
                $(this).val(value.toFixed(2));
            } else {
                $(this).val('');
            }
        });
    });
    function calCashBalance(){
        var cash = parseFloat($('#cash').val());
        var pay_out = parseFloat($('#pay_out').val());
        var cashBalance = cash - pay_out;
        $("#cash_balance").val(parseFloat(cashBalance).toFixed(2));
    }
</script>

@endsection
