@extends('layouts.admin')
@section('content')

<div class="content-body">
    <!-- <div class="row page-titles mx-0">
        <div class="col p-md-0">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.stores.index') }}">{{ trans('cruds.store.title_singular') }}</a></li>
                <li class="breadcrumb-item active">{{ trans('global.edit') }} {{ trans('cruds.store.title_singular') }}</li>
            </ol>
        </div>
    </div> -->

    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                {{ trans('global.edit') }} {{ trans('cruds.store.title_singular') }}
            </div>

            <div class="card-body">
                <form action="{{ route('admin.stores.update', [$store->id]) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="created_by" id="created_by" value="{{ auth()->id() }}">
                    <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                        <label for="name">{{ trans('cruds.store.fields.name') }}*</label>
                        <input type="text" id="name" name="name" class="form-control" value="{{ old('name', isset($store) ? $store->name : '') }}" required>
                        @if($errors->has('name'))
                            <em class="invalid-feedback">
                                {{ $errors->first('name') }}
                            </em>
                        @endif
                        <p class="helper-block">
                            {{ trans('cruds.store.fields.name_helper') }}
                        </p>
                    </div>
                    <div class="form-group {{ $errors->has('contact_number') ? 'has-error' : '' }}">
                        <label for="contact_number">{{ trans('cruds.store.fields.contact_number') }}*</label>
                        <input type="number" id="contact_number" name="contact_number" class="form-control" value="{{ old('contact_number', isset($store) ? $store->contact_number : '') }}" required>
                        @if($errors->has('contact_number'))
                            <em class="invalid-feedback">
                                {{ $errors->first('contact_number') }}
                            </em>
                        @endif
                        <p class="helper-block">
                            {{ trans('cruds.store.fields.contact_number_helper') }}
                        </p>
                    </div>
                    <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                        <label for="email">{{ trans('cruds.store.fields.email') }}*</label>
                        <input type="text" id="email" name="email" class="form-control" value="{{ old('email', isset($store) ? $store->email : '') }}" required>
                        @if($errors->has('email'))
                            <em class="invalid-feedback">
                                {{ $errors->first('email') }}
                            </em>
                        @endif
                        <p class="helper-block">
                            {{ trans('cruds.store.fields.email_helper') }}
                        </p>
                    </div>
                    <div class="form-group {{ $errors->has('address_line1') ? 'has-error' : '' }}">
                        <label for="address_line1">{{ trans('cruds.store.fields.address_line1') }}</label>
                        <textarea class="form-control h-150px" rows="6" id="comment" id="address_line1" name="address_line1" >{{ old('address_line1', isset($store) ? $store->address_line1 : '') }}</textarea>
                        @if($errors->has('address_line1'))
                            <em class="invalid-feedback">
                                {{ $errors->first('address_line1') }}
                            </em>
                        @endif
                        <p class="helper-block">
                            {{ trans('cruds.store.fields.address_line1_helper') }}
                        </p>
                    </div>
                    <div class="form-group {{ $errors->has('address_line2') ? 'has-error' : '' }}">
                        <label for="address_line2">{{ trans('cruds.store.fields.address_line2') }}</label>
                        <textarea class="form-control h-150px" rows="6" id="comment" id="address_line2" name="address_line2" >{{ old('address_line2', isset($store) ? $store->address_line2 : '') }}</textarea>
                        @if($errors->has('address_line2'))
                            <em class="invalid-feedback">
                                {{ $errors->first('address_line2') }}
                            </em>
                        @endif
                        <p class="helper-block">
                            {{ trans('cruds.store.fields.address_line2_helper') }}
                        </p>
                    </div>
                    <div class="form-group {{ $errors->has('city') ? 'has-error' : '' }}">
                        <label for="city">{{ trans('cruds.store.fields.city') }}*</label>
                        <input type="text" id="city" name="city" class="form-control" value="{{ old('city', isset($store) ? $store->city : '') }}" required>
                        @if($errors->has('city'))
                            <em class="invalid-feedback">
                                {{ $errors->first('city') }}
                            </em>
                        @endif
                        <p class="helper-block">
                            {{ trans('cruds.store.fields.city_helper') }}
                        </p>
                    </div>
                    <div class="form-group {{ $errors->has('state') ? 'has-error' : '' }}">
                        <label for="state">{{ trans('cruds.store.fields.state') }}*</label>
                        <input type="text" id="state" name="state" class="form-control" value="{{ old('state', isset($store) ? $store->state : '') }}" required>
                        @if($errors->has('state'))
                            <em class="invalid-feedback">
                                {{ $errors->first('state') }}
                            </em>
                        @endif
                        <p class="helper-block">
                            {{ trans('cruds.store.fields.state_helper') }}
                        </p>
                    </div>
                    <div class="form-group {{ $errors->has('country') ? 'has-error' : '' }}">
                        <label for="country">{{ trans('cruds.store.fields.country') }}*</label>
                        <input type="text" id="country" name="country" class="form-control" value="{{ old('country', isset($store) ? $store->country : '') }}" required>
                        @if($errors->has('country'))
                            <em class="invalid-feedback">
                                {{ $errors->first('country') }}
                            </em>
                        @endif
                        <p class="helper-block">
                            {{ trans('cruds.store.fields.country_helper') }}
                        </p>
                    </div>
                    <div class="form-group {{ $errors->has('postal_code') ? 'has-error' : '' }}">
                        <label for="postal_code">{{ trans('cruds.store.fields.postal_code') }}*</label>
                        <input type="text" id="postal_code" name="postal_code" class="form-control" value="{{ old('postal_code', isset($store) ? $store->postal_code : '') }}" required>
                        @if($errors->has('postal_code'))
                            <em class="invalid-feedback">
                                {{ $errors->first('postal_code') }}
                            </em>
                        @endif
                        <p class="helper-block">
                            {{ trans('cruds.store.fields.postal_code_helper') }}
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
