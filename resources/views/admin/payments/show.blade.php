@extends('layouts.admin')
@section('content')

<div class="content-body">
    <!-- <div class="row page-titles mx-0">
        <div class="col p-md-0">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.payments.index') }}">{{ trans('cruds.payment.title_singular') }}</a></li>
                <li class="breadcrumb-item active">{{ trans('global.show') }} {{ trans('cruds.payment.title_singular') }}</li>
            </ol>
        </div>
    </div> -->

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
                                    {{ trans('cruds.payment.fields.invoice_details') }}
                                </th>
                                <td>
                                    <table>
                                        <tr>
                                            <td>{{ trans('cruds.payment.fields.invoice_number') }} </td>
                                            <td>{{ $payment->invoice->invoice_number ?? '' }}</td>
                                        </tr>
                                        <tr>
                                            <td>{{ trans('cruds.payment.fields.invoice_total_amount') }}</td>
                                            <td>{{ $payment->invoice->amount ?? '' }}</td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    {{ trans('cruds.payment.fields.payment_type') }}
                                </th>
                                <td>
                                    {{ $payment->payment_type->name ?? '' }}
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
                            <tr>
                                <th>Action</th>
                                <td>

                                    @can('payment_edit')
                                        <a class="btn btn-xs btn-info mt-1 mt-md-0" href="{{ route('admin.payments.edit', $payment->id) }}">
                                            {{ trans('global.edit') }}
                                        </a>
                                    @endcan

                                    <!-- @can('payment_delete')
                                    <button class="btn btn-xs btn-danger delete-payment" data-id="{{ $payment->id }}">
                                        {{ trans('global.delete') }}
                                    </button>
                                        @endcan -->

                                    @can('payment_delete')
                                        <form action="{{ route('admin.payments.destroy', $payment->id) }}" method="POST" style="display: inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <input type="submit" class="btn btn-xs btn-danger mt-1 mt-md-0 delete-btn" value="{{ trans('global.delete') }}">
                                        </form>
                                    @endcan

                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <a style="margin-top:20px;" class="btn btn-secondary" href="{{ route("admin.payments.index") }}">
                        {{ trans('global.back_to_list') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
