@extends('layouts.admin')
@section('content')
<div class="content-body">
    <div class="container-fluid mt-3">
        <!-- Personalized Greeting -->
        <div class="row mb-4">
            <div class="col-lg-12">
                <div class="card gradient-4 text-white">
                    <div class="card-body">
                        <h2 class="mb-0">Hi, {{ Auth::user()->name }}!</h2>
                        <p class="mb-0">Welcome back to your dashboard. Here's an overview of your recent activity.</p>
                    </div>
                </div>
            </div>
        </div>
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
    <div class="col d-flex justify-content-start">
        <form method="GET" action="{{ route('admin.dashboard.index') }}" class="form-inline">
            <div class="row">
                <div class="col-md-6 form-group">
                    <select name="supplier_id" id="supplier_id" class="header-select form-control" data-selected="{{ $supplier_id }}">
                        <option value="0" {{ $supplier_id == 0 ? 'selected' : '' }}>All</option>
                        @foreach($suppliers as $supplier)
                            <option value="{{ $supplier->id }}" {{ $supplier_id == $supplier->id ? 'selected' : '' }}>
                                {{ $supplier->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </form>
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
                                            <th>Invoice Number</th>
                                            <th>Suplliers</th>
                                            <th>Amount</th>
                                            <th>Balance</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($invoices as $invoice)
                                            <tr data-entry-id="{{ $invoice->id }}" 
                                        onclick="window.location='{{ route('admin.invoices.show', $invoice->id) }}';" 
                                        style="cursor: pointer;" >
                                                <td><span>{{ $invoice->invoice_number ?? "" }}</span></td>
                                                <td><span>{{ $invoice->supplier ? $invoice->supplier->name : "" }}</span></td>
                                                <td><span><i class="fa fa-pound-sign"></i>{{ $invoice->amount ?? "" }}</span></td>
                                                <td><span><i class="fa fa-pound-sign"></i>{{ $invoice->balance ?? "" }}</span></td>
                                                @php
                                                    if($invoice->balance == 0){
                                                        $width = 100;
                                                        $class = 'bg-success';
                                                    }elseif( ($invoice->amount - $invoice->balance) >= $invoice->balance){
                                                        $width = number_format((($invoice->amount - $invoice->balance) / $invoice->amount) * 100, 2);
                                                        $class = 'bg-success';
                                                    }elseif( ($invoice->amount - $invoice->balance) < $invoice->balance){
                                                        $width = number_format((($invoice->amount - $invoice->balance) / $invoice->amount) * 100, 2);
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
</div>
@endsection
<style>
 @media (min-width: 768px) {
  .col-md-6 {
      flex: 0 0 50%;
       max-width: 100% !important; 
  }
}


    .form-group .header-select {
        border-radius: 8px !important; /* Rounded corners */
        border: 1px solid #ccc!important; /* Light border */
        padding: 10px 15px!important; /* Increase padding for better click area */
        font-size: 16px!important; /* Adjust font size for better readability */
        height: 105px!important; /* Increase height */
    }

    .form-group .header-select:hover {
        background-color: #f0f0f0!important; /* Light gray on hover */
        border-color: #999!important; /* Darker border on hover */
        cursor: pointer!important; /* Pointer cursor */
    }

    .form-group .header-select:focus {
        outline: none!important; /* Remove default focus outline */
        box-shadow: 0 0 5px rgba(0, 123, 255, 0.5)!important; /* Add focus shadow */
        border-color: #007bff!important; /* Border color on focus */
    }

    .form-group {
        display: flex!important;
        justify-content: flex-start!important; /* Align to the left */
    }
    .select2-container--default .select2-search--dropdown .select2-search__field {
      border-radius: 8px;
  }

  .select2-results__option {
    border-radius: 8px;
    }
</style>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>



<script>
$(document).ready(function () {
    // Initialize Select2
    $('#supplier_id').select2({
        placeholder: "All", // Ensure the placeholder says "All"
        allowClear: true, // Allow clearing
        width: 'resolve', // Adjust dropdown width
    });

    // Prevent form submission during initialization
    let initialized = false;

    $('#supplier_id').on('change', function () {
        if (initialized) {
            this.form.submit(); // Submit the form only after initialization is complete
        }
    });

    // Set the selected value to "All" if none is selected or based on server-side data
    var selectedValue = $('#supplier_id').data('selected'); // Get selected value from a data attribute
    if (!selectedValue || selectedValue === "0") {
        $('#supplier_id').val("0").trigger('change.select2'); // Set "All" as the default
    } else {
        $('#supplier_id').val(selectedValue).trigger('change.select2'); // Set the server-provided value
    }

    // Mark initialization as complete
    initialized = true;
});

</script>
