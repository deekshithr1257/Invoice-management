@extends('layouts.admin')
@section('content')

<div class="content-body">
    <div class="row page-titles mx-0">
        <div class="col p-md-0">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.roles.index') }}">Roles</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Create</a></li>
            </ol>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        {{ trans('global.create') }} {{ trans('cruds.role.title_singular') }}
                    </div>

                    <div class="card-body">
                        <form action="{{ route("admin.roles.store") }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
                                <label for="title">{{ trans('cruds.role.fields.title') }}*</label>
                                <input type="text" id="title" name="title" class="form-control" value="{{ old('title', isset($role) ? $role->title : '') }}" required>
                                @if($errors->has('title'))
                                    <em class="invalid-feedback">
                                        {{ $errors->first('title') }}
                                    </em>
                                @endif
                                <p class="helper-block">
                                    {{ trans('cruds.role.fields.title_helper') }}
                                </p>
                            </div>
                            <div class="form-group {{ $errors->has('permissions') ? 'has-error' : '' }}">
                                <label for="permissions" class="d-flex justify-content-between align-items-center">
                                    <span>{{ trans('cruds.role.fields.permissions') }}*</span>
                                    <div>
                                        <button type="button" class="btn btn-info btn-xs select-all">{{ trans('global.select_all') }}</button>
                                        <button type="button" class="btn btn-info btn-xs deselect-all">{{ trans('global.deselect_all') }}</button>
                                    </div>
                                </label>
                                <select name="permissions[]" id="permissions" class="form-control select2" multiple="multiple" required>
                                    @foreach($permissions as $id => $permissions)
                                        <option value="{{ $id }}" {{ (in_array($id, old('permissions', [])) || isset($role) && $role->permissions->contains($id)) ? 'selected' : '' }}>{{ $permissions }}</option>
                                    @endforeach
                                </select>
                                @if($errors->has('permissions'))
                                    <em class="invalid-feedback">
                                        {{ $errors->first('permissions') }}
                                    </em>
                                @endif
                                <p class="helper-block">
                                    {{ trans('cruds.role.fields.permissions_helper') }}
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

@endsection

<!-- Include jQuery first (Make sure this is included before any other JS files that depend on jQuery) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Initialize Select2 -->
<script>
    $(document).ready(function() {
        // Initialize Select2 on the permissions dropdown
        $('#permissions').select2({
            placeholder: "Select permissions",
            allowClear: true,
            width: '100%' // Make the select take the full width of the container
        });

        // Select All
        $('.select-all').click(function() {
            // Select all options by setting the value of the select element
            var allValues = [];
            $('#permissions option').each(function() {
                allValues.push($(this).val());
            });
            $('#permissions').val(allValues).trigger('change'); // Update Select2
        });

        // Deselect All
        $('.deselect-all').click(function() {
            // Clear the selection
            $('#permissions').val([]).trigger('change'); // Update Select2
        });
    });
</script>


