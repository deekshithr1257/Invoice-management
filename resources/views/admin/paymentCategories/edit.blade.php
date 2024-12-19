@extends('layouts.admin')
@section('content')

<div class="content-body">
    <div class="row page-titles mx-0">
        <div class="col p-md-0">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.payment-categories.index') }}">{{ trans('cruds.paymentCategory.title_singular') }}</a></li>
                <li class="breadcrumb-item active">{{ trans('global.edit') }} {{ trans('cruds.paymentCategory.title_singular') }}</li>
            </ol>
        </div>
    </div>

    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                {{ trans('global.edit') }} {{ trans('cruds.paymentCategory.title_singular') }}
            </div>

            <div class="card-body">
                <form action="{{ route("admin.payment-categories.update", [$paymentCategory->id]) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                        <label for="name">{{ trans('cruds.paymentCategory.fields.name') }}*</label>
                        <input type="text" id="name" name="name" class="form-control" value="{{ old('name', isset($paymentCategory) ? $paymentCategory->name : '') }}" required>
                        @if($errors->has('name'))
                            <em class="invalid-feedback">
                                {{ $errors->first('name') }}
                            </em>
                        @endif
                        <p class="helper-block">
                            {{ trans('cruds.paymentCategory.fields.name_helper') }}
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

@endsection
