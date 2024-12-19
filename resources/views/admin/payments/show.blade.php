@extends('layouts.admin')
@section('content')

<div class="content-body">
    <div class="row page-titles mx-0">
        <div class="col p-md-0">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.payments.index') }}">{{ trans('cruds.payment.title_singular') }}</a></li>
                <li class="breadcrumb-item active">{{ trans('global.show') }} {{ trans('cruds.payment.title_singular') }}</li>
            </ol>
        </div>
    </div>

    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                {{ trans('global.show') }} {{ trans('cruds.payment.title_singular') }}
            </div>

            <div class="card-body">
                <div class="mb-2">
                    <table class="table table-bordered table-striped">
                        <tbody>
                            <tr>
                                <th>
                                    {{ trans('cruds.payment.fields.id') }}
                                </th>
                                <td>
                                    {{ $payment->id }}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    {{ trans('cruds.payment.fields.payment_category') }}
                                </th>
                                <td>
                                    {{ $payment->payment_category->name ?? '' }}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    {{ trans('cruds.payment.fields.entry_date') }}
                                </th>
                                <td>
                                    {{ $payment->entry_date }}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    {{ trans('cruds.payment.fields.amount') }}
                                </th>
                                <td>
                                    ${{ number_format($payment->amount, 2) }}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    {{ trans('cruds.payment.fields.description') }}
                                </th>
                                <td>
                                    {{ $payment->description }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <a style="margin-top:20px;" class="btn btn-default" href="{{ url()->previous() }}">
                        {{ trans('global.back_to_list') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
