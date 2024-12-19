@extends('layouts.admin')
@section('content')

<div class="content-body">
    <div class="row page-titles mx-0">
        <div class="col p-md-0">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.invoice-categories.index') }}">{{ trans('cruds.invoiceCategory.title_singular') }}</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">{{ trans('global.show') }} {{ trans('cruds.invoiceCategory.title_singular') }}</a></li>
            </ol>
        </div>
    </div>

    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                {{ trans('global.show') }} {{ trans('cruds.invoiceCategory.title_singular') }}
            </div>

            <div class="card-body">
                <div class="mb-2">
                    <table class="table table-bordered table-striped">
                        <tbody>
                            <tr>
                                <th>
                                    {{ trans('cruds.invoiceCategory.fields.id') }}
                                </th>
                                <td>
                                    {{ $invoiceCategory->id }}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    {{ trans('cruds.invoiceCategory.fields.name') }}
                                </th>
                                <td>
                                    {{ $invoiceCategory->name }}
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
                        <!-- Tabs for additional content can be added here if needed -->
                    </div>
                </nav>
                <div class="tab-content">
                    <!-- Tab content can go here if needed -->
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
