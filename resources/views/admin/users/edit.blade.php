@extends('layouts.admin')
@section('content')

<div class="content-body">
    <div class="row page-titles mx-0">
        <div class="col p-md-0">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">Users</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">{{ trans('global.edit') }} {{ trans('cruds.user.title_singular') }}</a></li>
            </ol>
        </div>
    </div>

    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                {{ trans('global.edit') }} {{ trans('cruds.user.title_singular') }}
            </div>

            <div class="card-body">
                <form action="{{ route('admin.users.update', [$user->id]) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                        <label for="name">{{ trans('cruds.user.fields.name') }}*</label>
                        <input type="text" id="name" name="name" class="form-control" value="{{ old('name', isset($user) ? $user->name : '') }}" required>
                        @if($errors->has('name'))
                            <em class="invalid-feedback">
                                {{ $errors->first('name') }}
                            </em>
                        @endif
                        <p class="helper-block">
                            {{ trans('cruds.user.fields.name_helper') }}
                        </p>
                    </div>

                    <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                        <label for="email">{{ trans('cruds.user.fields.email') }}*</label>
                        <input type="email" id="email" name="email" class="form-control" value="{{ old('email', isset($user) ? $user->email : '') }}" required>
                        @if($errors->has('email'))
                            <em class="invalid-feedback">
                                {{ $errors->first('email') }}
                            </em>
                        @endif
                        <p class="helper-block">
                            {{ trans('cruds.user.fields.email_helper') }}
                        </p>
                    </div>

                    <div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
                        <label for="password">{{ trans('cruds.user.fields.password') }}</label>
                        <input type="password" id="password" name="password" class="form-control">
                        @if($errors->has('password'))
                            <em class="invalid-feedback">
                                {{ $errors->first('password') }}
                            </em>
                        @endif
                        <p class="helper-block">
                            {{ trans('cruds.user.fields.password_helper') }}
                        </p>
                    </div>

                    <div class="form-group {{ $errors->has('roles') ? 'has-error' : '' }}">
                        <label for="roles" class="d-flex justify-content-between align-items-center">
                            <span>{{ trans('cruds.user.fields.roles') }}*</span>
                            <div>
                            <span  type="button" class="btn btn-info btn-xs select-all">{{ trans('global.select_all') }}</span>
                            <span  type="button" class="btn btn-info btn-xs deselect-all">{{ trans('global.deselect_all') }}</span>
                            </div>
                        </label>
                        <select name="roles[]" id="roles" class="form-control select2" multiple="multiple" required>
                            @foreach($roles as $id => $roles)
                                <option value="{{ $id }}" {{ (in_array($id, old('roles', [])) || isset($user) && $user->roles->contains($id)) ? 'selected' : '' }}>{{ $roles }}</option>
                            @endforeach
                        </select>
                        @if($errors->has('roles'))
                            <em class="invalid-feedback">
                                {{ $errors->first('roles') }}
                            </em>
                        @endif
                        <p class="helper-block">
                            {{ trans('cruds.user.fields.roles_helper') }}
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

<!-- Include jQuery first (Make sure this is included before any other JS files that depend on jQuery) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Initialize Select2 -->
<script>
    $(document).ready(function() {
        // Initialize Select2 on the roles dropdown
        $('#roles').select2({
            placeholder: "Select roles",
            allowClear: true,
            width: '100%' // Make the select take the full width of the container
        });

        // Select All
        $('.select-all').click(function() {
            // Select all options by setting the value of the select element
            var allValues = [];
            $('#roles option').each(function() {
                allValues.push($(this).val());
            });
            $('#roles').val(allValues).trigger('change'); // Update Select2
        });

        // Deselect All
        $('.deselect-all').click(function() {
            // Clear the selection
            $('#roles').val([]).trigger('change'); // Update Select2
        });
    });
</script>

@endsection
