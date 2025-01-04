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
                                    {{ trans('cruds.supplier.fields.id') }}
                                </th>
                                <td>
                                    {{ $supplier->id }}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    {{ trans('cruds.supplier.fields.name') }}
                                </th>
                                <td>
                                    {{ $supplier->name }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <a class="btn btn-default" href="{{ url()->previous() }}">
                        {{ trans('global.back_to_list') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
