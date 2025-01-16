@extends('layouts.admin')
@section('content')

<div class="content-body">
    <!-- <div class="row page-titles mx-0">
        <div class="col p-md-0">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.stores.index') }}">{{ trans('cruds.store.title_singular') }}</a></li>
                <li class="breadcrumb-item active">{{ trans('global.show') }} {{ trans('cruds.store.title_singular') }}</li>
            </ol>
        </div>
    </div> -->

    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                {{ trans('global.show') }} {{ trans('cruds.store.title_singular') }}
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <tbody>
                            <tr>
                                <th>
                                    {{ trans('cruds.store.fields.name') }}
                                </th>
                                <td>
                                    {{ $store->name }}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    {{ trans('cruds.store.fields.contact_number') }}
                                </th>
                                <td>
                                    {{ $store->contact_number }}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    {{ trans('cruds.store.fields.email') }}
                                </th>
                                <td>
                                    {{ $store->email }}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    {{ trans('cruds.store.fields.address_line1') }}
                                </th>
                                <td>
                                    {{ $store->address_line1 }}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    {{ trans('cruds.store.fields.address_line2') }}
                                </th>
                                <td>
                                    {{ $store->address_line2 }}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    {{ trans('cruds.store.fields.city') }}
                                </th>
                                <td>
                                    {{ $store->city }}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    {{ trans('cruds.store.fields.state') }}
                                </th>
                                <td>
                                    {{ $store->state }}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    {{ trans('cruds.store.fields.country') }}
                                </th>
                                <td>
                                    {{ $store->country }}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    {{ trans('cruds.store.fields.postal_code') }}
                                </th>
                                <td>
                                    {{ $store->postal_code }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <a class="btn btn-default" href="{{ route("admin.stores.index") }}">
                        {{ trans('global.back_to_list') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
