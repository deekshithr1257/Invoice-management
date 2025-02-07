<!DOCTYPE html>
<html>
<head>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #ccc;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        .footer {
            margin-top: 20px;
            font-size: 12px;
        }
    </style>
</head>
<body>
    
    <table class="table table-xs mb-0" id="invoiceTable1">
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
                    <td><span>{{ \Carbon\Carbon::parse($invoice->entry_date)->format('d/m/Y') ?? '' }}</span></td>
                    <td><span>{{ $invoice->invoice_number ?? "" }}</span></td>
                    <td><span>{{ $invoice->supplier ? $invoice->supplier->name : "" }}</span></td>
                    <td><span><i class="fa fa-pound-sign"></i> {{ $invoice->amount ?? "" }}</span></td>
                    <td><span><i class="fa fa-pound-sign"></i> {{ $invoice->balance ?? "" }}</span></td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <table class="table table-xs mb-0" id="invoiceTable2">
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
                <td><span><i class="fa fa-pound-sign"></i> {{ $currentMonth ? number_format($currentMonth, 2) : "0.00" }}</span></td>
                <td><span><i class="fa fa-pound-sign"></i> {{ $period1 ? number_format($period1, 2) : "0.00" }}</span></td>
                <td><span><i class="fa fa-pound-sign"></i> {{ $period2 ? number_format($period2, 2) : "0.00" }}</span></td>
                <td><span><i class="fa fa-pound-sign"></i> {{ $older ? number_format($older, 2) : "0.00" }}</span></td>
                <td><span><i class="fa fa-pound-sign"></i> {{ $total ? number_format($total, 2) : "0.00" }}</span></td>
            </tr>
        </tbody>
    </table>
    <div class="footer">
        <p>All values are shown in Pound Sterling</p>
    </div>
</body>
</html>
