@extends('layouts.admin')
@section('content')

<div class="content-body">
    <!-- <div class="row page-titles mx-0">
        <div class="col p-md-0">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="javascript:void(0)">Permissions</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Show</a></li>
            </ol>
        </div>
    </div> -->

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">{{ trans('global.show') }} {{ trans('cruds.permission.title') }}</h4>
                        <div class="basic-form">
                            <div class="mb-2">
                                <table class="table table-bordered table-striped">
                                    <tbody>
                                        <tr>
                                            <th>
                                                {{ trans('cruds.permission.fields.id') }}
                                            </th>
                                            <td>
                                                {{ $permission->id }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>
                                                {{ trans('cruds.permission.fields.title') }}
                                            </th>
                                            <td>
                                                {{ $permission->title }}
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
                                    <!-- Tabs can be added here if needed -->
                                </div>
                            </nav>

                            <div class="tab-content">
                                <!-- Tab content can be added here if needed -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
