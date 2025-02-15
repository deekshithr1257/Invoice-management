@extends('layouts.admin')
@section('content')

<div class="content-body">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                {{ trans('global.show') }} {{ trans('cruds.sales.title_singular') }}
            </div>

            <div class="card-body">
                <div class="mb-2">
                    <table class="table table-bordered table-striped">
                        <tbody>
                            <tr>
                                <th>
                                    {{ trans('cruds.sales.fields.id') }}
                                </th>
                                <td>
                                    {{ $sale->id }}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    {{ trans('cruds.sales.fields.entry_date') }}
                                </th>
                                <td>
                                {{ \Carbon\Carbon::parse($sale->entry_date)->format('d/m/Y') ?? '' }}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    {{ trans('cruds.sales.fields.cash') }}
                                </th>
                                <td>
                                    <i class="fa fa-pound-sign"></i> {{ $sale->cash ?? '' }}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    {{ trans('cruds.sales.fields.pay_out') }}
                                </th>
                                <td>
                                    <i class="fa fa-pound-sign"></i> {{ $sale->pay_out ?? '' }}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    {{ trans('cruds.sales.fields.pay_out_admin') }}
                                </th>
                                <td>
                                    <i class="fa fa-pound-sign"></i> {{ $sale->pay_out_admin ?? '' }}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    {{ trans('cruds.sales.fields.admin_collection_date') }}
                                </th>
                                <td>
                                {{ $sale->admin_collection_date ? \Carbon\Carbon::parse($sale->admin_collection_date)->format('d/m/Y') : 'Not Yet Collected' }}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    {{ trans('cruds.sales.fields.cash_balance') }}
                                </th>
                                <td>
                                    <i class="fa fa-pound-sign"></i> {{ number_format($sale->cash_balance, 2) }}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    {{ trans('cruds.sales.fields.card') }}
                                </th>
                                <td>
                                    <i class="fa fa-pound-sign"></i> {{ $sale->card ?? '' }}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    {{ trans('cruds.sales.fields.description') }}
                                </th>
                                <td>
                                    {{ $sale->description }}
                                </td>
                            </tr>

                            @if($sale->pay_out_admin == 0)
                                <tr>
                                    <th>Action</th>
                                    <td>
                                        @can('sale_edit')
                                            <a class="btn btn-xs btn-info mt-1 mt-md-0" href="{{ route('admin.sales.edit', $sale->id) }}">
                                                {{ trans('global.edit') }}
                                            </a>
                                        @endcan
                                        @can('sale_delete')
                                            <form action="{{ route('admin.sales.destroy', $sale->id) }}" method="POST" style="display: inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <input type="submit" class="btn btn-xs btn-danger mt-1 mt-md-0 delete-btn" value="{{ trans('global.delete') }}">
                                            </form>
                                        @endcan

                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                    <a style="margin-top:20px;" class="btn btn-secondary" href="{{ route("admin.sales.index") }}">
                        {{ trans('global.back_to_list') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
