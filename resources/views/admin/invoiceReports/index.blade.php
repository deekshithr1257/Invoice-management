@extends('layouts.admin')
@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

<div class="content-body">
    <div class="container-fluid">
        <div class="row">
            <div class="col">
                <h3 class="page-title">{{ trans('cruds.invoiceReport.reports.title') }}</h3>
                

                <form method="get">
                    <div class="row">
                        <div class="col-2 form-group {{ $errors->has('from_date') ? 'has-error' : '' }}">
                            <label for="from_date">{{ trans('cruds.invoiceReport.reports.from_date') }}*</label>
                            <input type="text" class="form-control date-picker" name="from_date" id="from_date"  placeholder="Select a date"
                                value="{{ request('from_date') }}" >
                            
                            @if($errors->has('from_date'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('from_date') }}
                                </div>
                            @endif
                        </div>
                        <div class="col-2 form-group {{ $errors->has('to_date') ? 'has-error' : '' }}">
                            <label for="to_date">{{ trans('cruds.invoiceReport.reports.to_date') }}*</label>
                            <input type="text" class="form-control date-picker" name="to_date" id="to_date"  placeholder="Select a date"
                                value="{{ request('to_date') }}">
                            
                            @if($errors->has('to_date'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('to_date') }}
                                </div>
                            @endif
                        </div>
                        <div class="col-2 form-group {{ $errors->has('supplier_id') ? 'has-error' : '' }}">
                            <label for="suppliers">{{ trans('cruds.invoiceReport.reports.supplier') }}</label>
                            <select name="supplier_id" id="supplier_id" class="header-select form-control w-100">
                                <option value="0" {{ $supplier_id == 0 ? 'selected' : '' }}>All</option>
                                @foreach($suppliers as $supplier)
                                    <option value="{{ $supplier->id }}" {{ $supplier_id == $supplier->id ? 'selected' : '' }}>
                                        {{ $supplier->name }}
                                    </option>
                                @endforeach
                            </select>
                            @if($errors->has('supplier_id'))
                                <em class="invalid-feedback">
                                    {{ $errors->first('supplier_id') }}
                                </em>
                            @endif
                        </div>
                        <div class="col-2">
                            <label class="control-label">&nbsp;</label><br>
                            <button class="btn btn-primary" type="submit">{{ trans('global.search') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="download-div">
                            <a href="{{ route('admin.invoice-reports.download', [
                                            'from_date' => request('from_date'),
                                            'to_date' => request('to_date'),
                                            'supplier_id' => request('supplier_id')
                                        ]) 
                                    }}" class="btn btn-primary" target="_blank">
                                Download Invoice PDF
                            </a>
                        </div>
                    </div>
                    <div class="active-member">
                        <div class="table-responsive">
                            <table class="table table-xs mb-0" id="invoiceTable">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Invoice Number</th>
                                        <th>Suplliers</th>
                                        <th>Amount</th>
                                        <th>Balance</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($invoiceDatas as $invoice)
                                        <tr>
                                            <td><span>{{ \Carbon\Carbon::parse($invoice->entry_date)->format('d/m/Y') ?? '' }}</span></td>
                                            <td><span>{{ $invoice->invoice_number ?? "" }}</span></td>
                                            <td><span>{{ $invoice->supplier ? $invoice->supplier->name : "" }}</span></td>
                                            <td><span><i class="fa fa-pound-sign"></i> {{ $invoice->amount ?? "" }}</span></td>
                                            <td><span><i class="fa fa-pound-sign"></i> {{ $invoice->balance ?? "" }}</span></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="pagination-wrapper">
                                {{ $invoiceDatas->links('pagination::bootstrap-4') }} <!-- Bootstrap pagination style -->
                            </div>
                        </div>
                    </div>
                </div>                        
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header"></div>
                    <div class="active-member">
                        <div class="table-responsive">
                            <table class="table table-xs mb-0" id="invoiceTable">
                                <thead>
                                    <tr>
                                        <th>Current</th>
                                        <th>Period 1</th>
                                        <th>Period 2</th>
                                        <th>Older</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><span><i class="fa fa-pound-sign"></i> {{ $currentMonth ?? "" }}</span></td>
                                        <td><span><i class="fa fa-pound-sign"></i> {{ $period1 ?? "" }}</span></td>
                                        <td><span><i class="fa fa-pound-sign"></i> {{ $period2 ?? "" }}</span></td>
                                        <td><span><i class="fa fa-pound-sign"></i> {{ $older ?? "" }}</span></td>
                                        <td><span><i class="fa fa-pound-sign"></i> {{ $total ?? "" }}</span></td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="pagination-wrapper"></div>
                        </div>
                    </div>
                </div>                        
            </div>
        </div>

        <div class="card">
            <div class="card-header"></div>
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <table class="table table-bordered table-striped">
                            <tr>
                                <th>{{ trans('cruds.invoiceReport.reports.payment') }}</th>
                                <td>{{ number_format($paymentsTotal, 2) }}</td>
                            </tr>
                            <tr>
                                <th>{{ trans('cruds.invoiceReport.reports.invoice') }}</th>
                                <td>{{ number_format($invoicesTotal, 2) }}</td>
                            </tr>
                            <tr>
                                <th>{{ trans('cruds.invoiceReport.reports.balance') }}</th>
                                <td>{{ number_format($balance, 2) }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col">
                        <table class="table table-bordered table-striped">
                            <tr>
                                <th>{{ trans('cruds.invoiceReport.reports.suppliers') }}</th>
                                <th>{{ number_format($invoicesTotal, 2) }}</th>
                            </tr>
                            @foreach($invoicesSummary as $inc)
                                <tr>
                                    <th>{{ $inc['name'] }}</th>
                                    <td>{{ number_format($inc['amount'], 2) }}</td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
@parent
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-ui-timepicker-addon/1.4.5/jquery-ui-timepicker-addon.min.js"></script>
<script>
    $('.date').datepicker({
        autoclose: true,
        dateFormat: "{{ config('panel.date_format_js') }}"
    });
</script>
@stop
<style>
    .download-div {
        text-align: right; /* Aligns the text to the right */
        float: right;      /* Ensures the div moves to the right */
    }
</style>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Flatpickr JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        flatpickr("#from_date", {
            dateFormat: "d-m-Y", // Adjust as needed
            allowInput: true
        });
        flatpickr("#to_date", {
            dateFormat: "d-m-Y", // Adjust as needed
            allowInput: true
        });
    });
    $(document).ready(function () {
        // Initialize Select2
        $('#supplier_id').select2({
            allowClear: true, // Allow clearing
            width: 'resolve', // Adjust dropdown width
        });
    });
</script>