@extends('layouts.admin')
@section('content')

<div class="content-body">
    <!-- <div class="row page-titles mx-0">
        <div class="col p-md-0">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">Users</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">{{ trans('global.show') }} {{ trans('cruds.user.title_singular') }}</a></li>
            </ol>
        </div>
    </div> -->

    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                {{ trans('global.show') }} {{ trans('cruds.user.title_singular') }}
            </div>

            <div class="card-body">
                <div class="mb-2">
                    <table class="table table-bordered table-striped">
                        <tbody>
                            <tr>
                                <th>
                                    {{ trans('cruds.user.fields.id') }}
                                </th>
                                <td>
                                    {{ $user->id }}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    {{ trans('cruds.user.fields.name') }}
                                </th>
                                <td>
                                    {{ $user->name }}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    {{ trans('cruds.user.fields.email') }}
                                </th>
                                <td>
                                    {{ $user->email }}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    {{ trans('cruds.user.fields.stores') }}
                                </th>
                                <td>
                                    @foreach($user->stores as $store)
                                        <span class="label label-info label-many">{{ $store->name }}</span>
                                    @endforeach
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    Roles
                                </th>
                                <td>
                                    @foreach($user->roles as $role)
                                        <span class="label label-info label-many">{{ $role->title }}</span>
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
                        <!-- Tab content if needed in the future -->
                    </div>
                </nav>
                <div class="tab-content">
                    <!-- Tab content if needed in the future -->
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
