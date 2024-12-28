@extends('layouts.admin')
@section('content')
<div class="content-body">
    <div class="container-fluid mt-3">
        @if(session('alert'))
            <div class="alert alert-warning">
                {{ session('alert') }}
            </div>
        @endif
        <div class="row">
            <div class="col-lg-3 col-sm-6">
                <div class="card gradient-1">
                    <div class="card-body">
                        <h3 class="card-title text-white">Invoice</h3>
                        <div class="d-inline-block">
                            <h2 class="text-white"><i class="fa fa-pound-sign"></i>{{ $total }}</h2>
                            <!-- <p class="text-white mb-0">Jan - March 2019</p> -->
                        </div>
                        <span class="float-right display-5 opacity-5"><i class="fas fa-file-invoice"></i></span>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="card gradient-2">
                    <div class="card-body">
                        <h3 class="card-title text-white">Payment</h3>
                        <div class="d-inline-block">
                            <h2 class="text-white"><i class="fa fa-pound-sign"></i>{{ $paid }}</h2>
                            <!-- <p class="text-white mb-0">Jan - March 2019</p> -->
                        </div>
                        <span class="float-right display-5 opacity-5"><i class="fa fa-money"></i></span>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="card gradient-3">
                    <div class="card-body">
                        <h3 class="card-title text-white">Balance</h3>
                        <div class="d-inline-block">
                            <h2 class="text-white"><i class="fa fa-pound-sign"></i>{{ $balance }}</h2>
                            <!-- <p class="text-white mb-0">Jan - March 2019</p> -->
                        </div>
                        <span class="float-right display-5 opacity-5"><i class="fa fa-balance-scale"></i></span>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="card gradient-4">
                    <div class="card-body">
                        <h3 class="card-title text-white">Payment Rate</h3>
                        <div class="d-inline-block">
                            <h2 class="text-white"> {{ $paymentRate }}%</h2>
                            <!-- <p class="text-white mb-0">Jan - March 2019</p> -->
                        </div>
                        <span class="float-right display-5 opacity-5"><i class="fa fa-chart-pie"></i></span>
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
                                <table class="table table-xs mb-0">
                                    <thead>
                                        <tr>
                                            <th>Suplliers</th>
                                            <th>Invoice Number</th>
                                            <th>Amount</th>
                                            <th>Balance</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($invoices as $invoice)
                                            <tr>
                                                <td><span>{{ $invoice->supplier ? $invoice->supplier->name : "" }}</span></td>
                                                <td><span>{{ $invoice->invoice_number ?? "" }}</span></td>
                                                <td><span><i class="fa fa-pound-sign"></i>{{ $invoice->amount ?? "" }}</span></td>
                                                <td><span><i class="fa fa-pound-sign"></i>{{ $invoice->balance ?? "" }}</span></td>
                                                @php
                                                    if($invoice->balance == 0){
                                                        $width = 100;
                                                        $class = 'bg-success';
                                                    }elseif( ($invoice->amount - $invoice->balance) > $invoice->balance){
                                                        $width = number_format((($invoice->amount - $invoice->balance) / $invoice->amount) * 100, 2);
                                                        $class = 'bg-success';
                                                    }elseif( ($invoice->amount - $invoice->balance) < $invoice->balance){
                                                        $width = number_format(($invoice->balance / $invoice->amount) * 100, 2);
                                                        $class = 'bg-warning';
                                                    }
                                                @endphp
                                                <td>
                                                    <div>
                                                        <div class="progress" style="height: 6px">
                                                            <div class="progress-bar {{ $class }}" style="width: {{ $width }}%"></div>
                                                        </div>
                                                    </div>    
                                                    <!-- <div>
                                                        <div class="progress" style="height: 6px">
                                                            <div class="progress-bar bg-warning" style="width: 50%"></div>
                                                        </div>
                                                    </div> -->
                                                    <!-- <i class="fa fa-circle-o text-success  mr-2"></i> Paid -->
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>                        
            </div>
        </div>
    </div>
</div>
@endsection