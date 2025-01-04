@extends('layouts.admin')
@section('content')

<div class="content-body">
    <!-- <div class="row page-titles mx-0">
        <div class="col p-md-0">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.payment-types.index') }}">{{ trans('cruds.paymentType.title_singular') }}</a></li>
                <li class="breadcrumb-item active">{{ trans('global.edit') }} {{ trans('cruds.paymentType.title_singular') }}</li>
            </ol>
        </div>
    </div> -->

    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                {{ trans('global.edit') }} {{ trans('cruds.paymentType.title_singular') }}
            </div>

            <div class="card-body">
                <form action="{{ route("admin.payment-types.update", [$paymentType->id]) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="created_by" id="created_by" value="{{ auth()->id() }}">
                    <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                        <label for="name">{{ trans('cruds.paymentType.fields.name') }}*</label>
                        <input type="text" id="name" name="name" class="form-control" value="{{ old('name', isset($paymentType) ? $paymentType->name : '') }}" required>
                        @if($errors->has('name'))
                            <em class="invalid-feedback">
                                {{ $errors->first('name') }}
                            </em>
                        @endif
                        <p class="helper-block">
                            {{ trans('cruds.paymentType.fields.name_helper') }}
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

@endsection
