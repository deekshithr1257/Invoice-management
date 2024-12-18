@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.payment.title_singular') }}
    </div>

    <div class="card-body">
        <form action="{{ route("admin.payments.update", [$payment->id]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group {{ $errors->has('payment_category_id') ? 'has-error' : '' }}">
                <label for="payment_category">{{ trans('cruds.payment.fields.payment_category') }}</label>
                <select name="payment_category_id" id="payment_category" class="form-control select2">
                    @foreach($payment_categories as $id => $payment_category)
                        <option value="{{ $id }}" {{ (isset($payment) && $payment->payment_category ? $payment->payment_category->id : old('payment_category_id')) == $id ? 'selected' : '' }}>{{ $payment_category }}</option>
                    @endforeach
                </select>
                @if($errors->has('payment_category_id'))
                    <em class="invalid-feedback">
                        {{ $errors->first('payment_category_id') }}
                    </em>
                @endif
            </div>
            <div class="form-group {{ $errors->has('entry_date') ? 'has-error' : '' }}">
                <label for="entry_date">{{ trans('cruds.payment.fields.entry_date') }}*</label>
                <input type="text" id="entry_date" name="entry_date" class="form-control date" value="{{ old('entry_date', isset($payment) ? $payment->entry_date : '') }}" required>
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
@endsection