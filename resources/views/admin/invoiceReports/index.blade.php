@extends('layouts.admin')
@section('content')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script>
    async function downloadPDF() {
        const { jsPDF } = window.jspdf;
        const table = document.getElementById('invoiceTable');
        const canvas = await html2canvas(table);
        const imgData = canvas.toDataURL('image/png');
        const pdf = new jsPDF();
        const imgWidth = pdf.internal.pageSize.getWidth() - 20;
        const imgHeight = (imgWidth / canvas.width) * canvas.height;
        pdf.addImage(imgData, 'PNG', 10, 10, imgWidth, imgHeight);
        month = $("#m").val();
        year = $("#y").val();
        pdf.save('invoice_report_'+month+'_'+year+'.pdf');
    }
</script>

<div class="content-body">

<div class="container-fluid">
<div class="row">
    <div class="col">
        <h3 class="page-title">{{ trans('cruds.invoiceReport.reports.title') }}</h3>
        

        <form method="get">
            <div class="row">
                <div class="col-3 form-group">
                    <label class="control-label" for="y">{{ trans('global.year') }}</label>
                    <select name="y" id="y" class="form-control">
                        @foreach(array_combine(range(date("Y"), 1900), range(date("Y"), 1900)) as $year)
                            <option value="{{ $year }}" @if($year===old('y', Request::get('y', date('Y')))) selected @endif>
                                {{ $year }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-3 form-group">
                    <label class="control-label" for="m">{{ trans('global.month') }}</label>
                    <select name="m" id="m" for="m" class="form-control">
                        @foreach(cal_info(0)['months'] as $month)
                            <option value="{{ $month }}" @if($month===old('m', Request::get('m', date('m')))) selected @endif>
                                {{ $month }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-4">
                    <label class="control-label">&nbsp;</label><br>
                    <button class="btn btn-primary" type="submit">{{ trans('global.filterDate') }}</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class="download-div"><button class="btn-download" onclick="downloadPDF()">Download as PDF</button></div>
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
                                @foreach($invoices as $invoice)
                                    <tr>
                                        <td><span>{{ $invoice->entry_date ?? "" }}</span></td>
                                        <td><span>{{ $invoice->invoice_number ?? "" }}</span></td>
                                        <td><span>{{ $invoice->supplier ? $invoice->supplier->name : "" }}</span></td>
                                        <td><span><i class="fa fa-pound-sign"></i>{{ $invoice->amount ?? "" }}</span></td>
                                        <td><span><i class="fa fa-pound-sign"></i>{{ $invoice->balance ?? "" }}</span></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="pagination-wrapper">
                       
                    </div>
                    </div>
                </div>
            </div>
        </div>                        
    </div>
</div>

<div class="card">
    <div class="card-header">
        {{ trans('cruds.invoiceReport.reports.paymentReport') }}
    </div>

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
    .btn-download {
        margin-top: 20px;
        padding: 10px 20px;
        background-color: #4CAF50;
        color: white;
        border: none;
        cursor: pointer;
    }
</style>
