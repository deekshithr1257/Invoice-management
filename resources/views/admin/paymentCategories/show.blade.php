@extends('layouts.admin')
@section('content')

<div class="content-body">
    <div class="row page-titles mx-0">
        <div class="col p-md-0">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.payment-categories.index') }}">{{ trans('cruds.paymentCategory.title_singular') }}</a></li>
                <li class="breadcrumb-item active">{{ trans('global.show') }} {{ trans('cruds.paymentCategory.title_singular') }}</li>
            </ol>
        </div>
    </div>

    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                {{ trans('global.show') }} {{ trans('cruds.paymentCategory.title_singular') }}
            </div>

            <div class="card-body">
                <div class="mb-2">
                    <table class="table table-bordered table-striped">
                        <tbody>
                            <tr>
                                <th>
                                    {{ trans('cruds.paymentCategory.fields.id') }}
                                </th>
                                <td>
                                    {{ $paymentCategory->id }}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    {{ trans('cruds.paymentCategory.fields.name') }}
                                </th>
                                <td>
                                    {{ $paymentCategory->name }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <a style="margin-top:20px;" class="btn btn-default" href="{{ url()->previous() }}">
                        {{ trans('global.back_to_list') }}
                    </a>
                </div>

                <!-- Optional Tabbed Content Section -->
                <nav class="mb-3">
                    <div class="nav nav-tabs">
                        <!-- Add tabs here if needed -->
                    </div>
                </nav>
                <div class="tab-content">
                    <!-- Add tab content here if needed -->
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
