<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        .header img {
            max-width: 150px;
        }
        .company-info {
            text-align: right;
        }
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
    <div class="header">
        <img src="{{ public_path('images/logo.jpg') }}" alt="Logo">
        <div class="company-info">
            <p>Head Office and Accounts</p>
            <p>Blacksmith Freight Services Ltd</p>
            <p>Unit 5 Building 303</p>
            <p>World Freight Terminal</p>
            <p>Manchester Airport, M90 5UJ</p>
            <p>Tel: +44 1614 990 804</p>
            <p>Email: accounts@blacksmithfreight.co.uk</p>
        </div>
    </div>
    <h3>Statement</h3>
    <p>To: Kuberan Cash and Carry Ltd</p>
    <p>Costcutter Waterside Village, Trentham Close, St Helens WA9 5GX</p>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
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
                        
                        </div>
                        </div>
                    </div>
                </div>
            </div>                        
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
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
                            <div class="pagination-wrapper">
                        
                        </div>
                        </div>
                    </div>
                </div>
            </div>                        
        </div>
    </div>
    <div class="footer">
        <p>All values are shown in Pound Sterling</p>
    </div>
</body>
</html>
