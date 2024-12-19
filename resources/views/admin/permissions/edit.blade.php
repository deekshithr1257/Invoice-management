@extends('layouts.admin')
@section('content')

<div class="content-body">
    <div class="row page-titles mx-0">
        <div class="col p-md-0">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="javascript:void(0)">Permissions</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Edit</a></li>
            </ol>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">{{ trans('global.edit') }} {{ trans('cruds.permission.title_singular') }}</h4>
                        <div class="basic-form">
                            <form action="{{ route("admin.permissions.update", [$permission->id]) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                
                                <div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
                                    <label for="title">{{ trans('cruds.permission.fields.title') }}*</label>
                                    <input type="text" id="title" name="title" class="form-control" value="{{ old('title', isset($permission) ? $permission->title : '') }}" required>
                                    @if($errors->has('title'))
                                        <em class="invalid-feedback">
                                            {{ $errors->first('title') }}
                                        </em>
                                    @endif
                                    <p class="helper-block">
                                        {{ trans('cruds.permission.fields.title_helper') }}
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
