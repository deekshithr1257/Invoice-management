@extends('layouts.admin')
@section('content')

<div class="content-body">
    <!-- <div class="row page-titles mx-0">
        <div class="col p-md-0">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.suppliers.index') }}">{{ trans('cruds.supplier.title_singular') }}</a></li>
                <li class="breadcrumb-item active">{{ trans('global.show') }} {{ trans('cruds.supplier.title_singular') }}</li>
            </ol>
        </div>
    </div> -->

    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                {{ trans('global.show') }} {{ trans('cruds.supplier.title_singular') }}
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <tbody>
                            <tr>
                                <th>
                                    {{ trans('cruds.supplier.fields.name') }}
                                </th>
                                <td>
                                    {{ $supplier->name }}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    {{ trans('cruds.supplier.fields.contact_number') }}
                                </th>
                                <td>
                                    {{ $supplier->contact_number }}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    {{ trans('cruds.supplier.fields.email') }}
                                </th>
                                <td>
                                    {{ $supplier->email }}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    {{ trans('cruds.supplier.fields.address_line1') }}
                                </th>
                                <td>
                                    {{ $supplier->address_line1 }}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    {{ trans('cruds.supplier.fields.address_line2') }}
                                </th>
                                <td>
                                    {{ $supplier->address_line2 }}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    {{ trans('cruds.supplier.fields.city') }}
                                </th>
                                <td>
                                    {{ $supplier->city }}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    {{ trans('cruds.supplier.fields.state') }}
                                </th>
                                <td>
                                    {{ $supplier->state }}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    {{ trans('cruds.supplier.fields.country') }}
                                </th>
                                <td>
                                    {{ $supplier->country }}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    {{ trans('cruds.supplier.fields.postal_code') }}
                                </th>
                                <td>
                                    {{ $supplier->postal_code }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <a class="btn btn-default" href="{{ route("admin.suppliers.index") }}">
                        {{ trans('global.back_to_list') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
