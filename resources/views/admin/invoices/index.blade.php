@extends('layouts.admin')
@section('content')


<div class="content-body">
    <div class="row page-titles mx-0">
        @can('invoice_create')
            <div style="margin-bottom: 10px;" class="row">
                <div class="col-lg-12">
                    <a class="btn btn-success" href="{{ route("admin.invoices.create") }}">
                        {{ trans('global.add') }} {{ trans('cruds.invoice.title_singular') }}
                    </a>
                </div>
            </div>
        @endcan
        <div class="col p-md-0">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Home</a></li>
            </ol>
        </div>
    </div>
    <!-- row -->

    <!-- Filter Section (Month Filter) -->
     
    <div class="container-fluid">
    <div class="row">
        <div class="col d-flex justify-content-end pe-5">
            <form method="get">
                <div class="row">
                    <div class="col-md-6 form-group">
                        <form method="GET" action="{{ route('admin.invoices.index') }}" class="form-inline">
                            <select name="supplier_id" id="supplier_id" class="header-select" onchange="this.form.submit()">
                                <option value="0" {{ $supplier_id == 0 ? 'selected':""}}>All</option>
                                @foreach($suppliers as $supplier)
                                    <option value="{{ $supplier->id }}" {{ $supplier_id == $supplier->id ? 'selected':""}}>
                                        {{ $supplier->name }}
                                    </option>
                                @endforeach
                            </select>
                        </form>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title"> {{ trans('cruds.invoice.title_singular') }} {{ trans('global.list') }}</h4>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered zero-configuration">
                            <thead>
                                <tr>
                                    <th>{{ trans('cruds.invoice.fields.invoice_number') }}</th>
                                    <th>{{ trans('cruds.invoice.fields.supplier') }}</th>
                                    <th>{{ trans('cruds.invoice.fields.entry_date') }}</th>
                                    <th>{{ trans('cruds.invoice.fields.amount') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($invoices as $key => $invoice)
                                    <tr 
                                        data-entry-id="{{ $invoice->id }}" 
                                        onclick="window.location='{{ route('admin.invoices.show', $invoice->id) }}';" 
                                        style="cursor: pointer;"
                                    >
                                        <td>{{ $invoice->invoice_number ?? '' }}</td>
                                        <td>{{ $invoice->supplier ? $invoice->supplier->name : '' }}</td>
                                        <td>{{ $invoice->entry_date ?? '' }}</td>
                                        <td>{{ $invoice->amount ?? '' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <!-- Pagination Links -->
                        <div class="pagination-wrapper">
                                {{ $invoices->links('pagination::bootstrap-4') }} <!-- Bootstrap pagination style -->
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</div>
@endsection
@section('scripts')
@parent
@endsection


