@extends('layouts.admin')
@section('content')

<div class="content-body">
    <!-- <div class="row page-titles mx-0">
        <div class="col p-md-0">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.roles.index') }}">Roles</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Show</a></li>
            </ol>
        </div>
    </div> -->

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        {{ trans('global.show') }} {{ trans('cruds.role.title_singular') }}
                    </div>

                    <div class="card-body">
                        <div class="mb-2">
                            <table class="table table-bordered table-striped">
                                <tbody>
                                    <tr>
                                        <th>
                                            {{ trans('cruds.role.fields.id') }}
                                        </th>
                                        <td>
                                            {{ $role->id }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            {{ trans('cruds.role.fields.title') }}
                                        </th>
                                        <td>
                                            {{ $role->title }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            Permissions
                                        </th>
                                        <td class="permissions-cell">
                                            @foreach($role->permissions as $id => $permissions)
                                                <span class="label label-info label-many">{{ $permissions->title }}</span>
                                            @endforeach
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <a style="margin-top:20px;" class="btn btn-default" href="{{ url()->previous() }}">
                                {{ trans('global.back_to_list') }}
                            </a>
                        </div>

                        <nav class="mb-3">
                            <div class="nav nav-tabs">
                                <!-- You can add additional tabs here if necessary -->
                            </div>
                        </nav>
                        <div class="tab-content">
                            <!-- You can add tab content here if necessary -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
