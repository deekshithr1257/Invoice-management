@extends('layouts.admin')
@section('content')


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
                    <select name="m" for="m" class="form-control">
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
                        <th>{{ trans('cruds.invoiceReport.reports.profit') }}</th>
                        <td>{{ number_format($profit, 2) }}</td>
                    </tr>
                </table>
            </div>
            <div class="col">
                <table class="table table-bordered table-striped">
                    <tr>
                        <th>{{ trans('cruds.invoiceReport.reports.paymentByCategory') }}</th>
                        <th>{{ number_format($paymentsTotal, 2) }}</th>
                    </tr>
                    @foreach($paymentsSummary as $inc)
                        <tr>
                            <th>{{ $inc['name'] }}</th>
                            <td>{{ number_format($inc['amount'], 2) }}</td>
                        </tr>
                    @endforeach
                </table>
            </div>
            <div class="col">
                <table class="table table-bordered table-striped">
                    <tr>
                        <th>{{ trans('cruds.invoiceReport.reports.invoiceByCategory') }}</th>
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
    })
</script>
@stop
