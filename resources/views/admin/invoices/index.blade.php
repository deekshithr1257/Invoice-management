@extends('layouts.admin')
@section('content')


<div class="content-body">
<div class="row page-titles mx-0">
    @can('invoice_create')
    <div class="col-lg-6 col-md-6 d-flex align-items-center mb-2 mb-lg-0">
        <a class="btn btn-success add-button" href="{{ route('admin.invoices.create') }}">
            {{ trans('global.add') }} {{ trans('cruds.invoice.title_singular') }}
        </a>
    </div>
    @endcan
    <div class="col-lg-6 col-md-6 d-flex align-items-center justify-content-end">
        <!-- Filter Form -->
        <form method="GET" action="{{ route('admin.invoices.index') }}" class="form-inline w-100">
            <div class="form-group mb-0 w-100">
                <select name="supplier_id" id="supplier_id" class="header-select form-control">
                    <option value="0" {{ $supplier_id == 0 ? 'selected' : '' }}>All</option>
                    @foreach($suppliers as $supplier)
                        <option value="{{ $supplier->id }}" {{ $supplier_id == $supplier->id ? 'selected' : '' }}>
                            {{ $supplier->name }}
                        </option>
                    @endforeach
                </select>
            </div>
        </form>
    </div>
</div>


    <!-- row -->

    <!-- Filter Section (Month Filter) -->
     
    <div class="container-fluid">
    <!-- <div class="row">
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
    </div> -->
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
                                    <th>{{ trans('cruds.invoice.fields.balance') }}</th>
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
                                        <td>{{ \Carbon\Carbon::parse($invoice->entry_date)->format('d/m/Y') ?? '' }}</td>
                                        <td>{{ $invoice->amount ?? '' }}</td>
                                        <td>{{ $invoice->balance ?? '' }}</td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <th colspan="4" style="text-align: right;">{{ trans('cruds.invoice.fields.total') }} (including all invoices)</th>
                                    <th>{{ $totalBalance }}</th>
                                </tr>
                            </tbody>
                        </table>
                        <!-- Pagination Links -->
                        <div class="pagination-wrapper">
                                {{ $invoices->links('pagination::bootstrap-4') }} <!-- Bootstrap pagination style -->
                            </div>
                        <table class="table table-striped table-bordered zero-configuration">
                            
                        </table>
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

<style>

@media (min-width: 992px) {
    .col-lg-12 {
        padding-right: 60px !important;
    }
}
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

/* General styles */
.add-button {
    white-space: nowrap; /* Prevent text wrapping */
    max-width: 200px; /* Limit button width */
}

/* Adjust padding for the Add button */
@media (min-width: 830px) {
    .row.page-titles {
        width: 404px; /* Set a fixed width for desktop */
    }
}

.header-select {
    width: 100%; /* Ensure the select fills its container */
}

@media (max-width: 830px) {
    .row.page-titles {
        display: flex;
        flex-wrap: nowrap; /* Prevent elements from stacking */
    }

    .col-lg-6,
    .col-md-6 {
        flex: 1; /* Share available space equally */
        max-width: 50%; /* Ensure equal width */
    }

    .add-button {
        max-width: none; /* Allow button to take full width */
    }

    .header-select {
        max-width: none; /* Allow select box to scale appropriately */
    }
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


