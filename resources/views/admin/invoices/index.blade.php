@extends('layouts.admin')
@section('content')

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<!-- <style>
   .fixed-element {
        position: fixed;
        top: 80px; /* Adjust this based on your header height */
        left: 15%; /* Center it horizontally */
        z-index: 1000; /* Ensure it sits above other content */
        width: 100%;
        padding: 20px; /* Space inside the box */
    }
    @media (max-width: 768px) {
        .fixed-element {
            width: 100%; /* Adjust width for smaller screens */
            top: 58px; /* You might want to adjust top for mobile screens */
            left: 51%;
        }
    }
</style> -->
<style>
    .d-flex {
        gap: 10px; /* Ensures spacing without affecting button alignment */
    }
    .row {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
        padding: 0.9375rem 1.875rem;
    }

    .add-button {
        white-space: nowrap;
    }

    .header-select {
        max-width: 100%;
        min-width: 150px;
    }
    @media (max-width: 427px) {
  .row {
    padding: 0.9375rem 0.175rem;
  }
  .btn {
    padding: 2px 10px !important;
  }
}
    th {
        text-align: center;
    }
        /* Alternating column colors */
    td:nth-child(even), th:nth-child(even) {
      background-color: #f9f9f9; /* Light grey */
    }
</style>
<div class="content-body">
<!-- <div class="row page-titles mx-0">
    <div class="fixed-element ">
        @can('invoice_create')
        <div class="col-lg-6 col-md-6 d-flex align-items-center mb-2 mb-lg-0">
            <a class="btn btn-success add-button" href="{{ route('admin.invoices.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.invoice.title_singular') }}
            </a>
        </div>
        @endcan
        <div class="col-lg-6 col-md-6 d-flex align-items-center justify-content-end">
            <!-- Filter Form -->
            <!-- <form method="GET" action="{{ route('admin.invoices.index') }}" class="form-inline w-100">
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
            <button id="makePaymentBtn" class="btn btn-primary mt-3" style="display: none;">
                Make Payment
            </button>
        </div>
    </div>
</div> -->
<div class="d-flex row align-items-center mx-0">
    <div class="col-lg-4 col-md-4 d-flex">
        <a class="btn btn-success add-button" href="{{ route('admin.invoices.create') }}">
           Add
        </a>
        <form method="GET" action="{{ route('admin.invoices.index') }}" class="form-inline w-100">
            <div class="form-group mb-0 w-100">
                <select name="supplier_id" id="supplier_id" class="header-select form-control w-100">
                    <option value="0" {{ $supplier_id == 0 ? 'selected' : '' }}>All</option>
                    @foreach($suppliers as $supplier)
                        <option value="{{ $supplier->id }}" {{ $supplier_id == $supplier->id ? 'selected' : '' }}>
                            {{ $supplier->name }}
                        </option>
                    @endforeach
                </select>
            </div>
        </form>
        <button id="makePaymentBtn" class="btn btn-primary" style="display: none;">
            Pay Now
        </button>
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
                        <table class="table table-bordered zero-configuration">
                            <thead>
                                <tr>
                                    @if($supplier_id != 0)
                                        <th><input type="checkbox" id="selectAll"></th>
                                    @endif
                                    <th>{{ trans('cruds.invoice.fields.invoice_number') }}</th>
                                    <th>{{ trans('cruds.invoice.fields.supplier') }}</th>
                                    <th>{{ trans('cruds.invoice.fields.entry_date') }}</th>
                                    <th>{{ trans('cruds.invoice.fields.amount') }}</th>
                                    <th>{{ trans('cruds.invoice.fields.vat') }}</th>
                                    <th>{{ trans('cruds.invoice.fields.balance') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($invoices as $key => $invoice)
                                    <tr 
                                        data-entry-id="{{ $invoice->id }}" 
                                        onclick="redirectToInvoice({{ $invoice->id }})"
                                        style="cursor: pointer;"
                                    >
                                        @if($supplier_id != 0)
                                            <td class="no-click" style="text-align: center;">
                                                @if($invoice->balance != 0)
                                                    <input type="checkbox" class="invoice-checkbox" 
                                                        data-id="{{ $invoice->id }}" 
                                                        data-amount="{{ $invoice->amount }}" 
                                                        data-balance="{{ $invoice->balance }}">
                                                @endif
                                            </td>
                                        @endif
                                        <td>{{ $invoice->invoice_number ?? '' }}</td>
                                        <td>{{ $invoice->supplier ? $invoice->supplier->name : '' }}</td>
                                        <td>{{ \Carbon\Carbon::parse($invoice->entry_date)->format('d/m/Y') ?? '' }}</td>
                                        <td class="amount" style="text-align: right;"><i class="fa fa-pound-sign"></i> {{ $invoice->amount ?? '' }}</td>
                                        <td style="text-align: right;"><i class="fa fa-pound-sign"></i> {{ $invoice->tax ?? '' }}</td>
                                        <td class="balance" style="text-align: right;"><i class="fa fa-pound-sign"></i> {{ $invoice->balance ?? '' }}</td>
                                    </tr>
                                @endforeach
                                <tr>
                                    @if($supplier_id != 0)
                                        <th colspan="6" style="text-align: right;">{{ trans('cruds.invoice.fields.total') }} (including all invoices across all pages)</th>
                                    @else
                                        <th colspan="5" style="text-align: right;">{{ trans('cruds.invoice.fields.total') }} (including all invoices across all pages)</th>
                                    @endif
                                    <th style="text-align: right;"><i class="fa fa-pound-sign"></i> {{ $totalBalance }}</th>
                                </tr>
                            </tbody>
                        </table>
                        <!-- Pagination Links -->
                        <div class="pagination-wrapper">
                                {{ $invoices->appends(['supplier_id' => $supplier_id])->links('pagination::bootstrap-4') }} <!-- Bootstrap pagination style -->
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

<div id="paymentModal" class="modal fade" tabindex="-1" role="dialog" style="display: none;">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Payment Summary</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <meta name="csrf-token" content="{{ csrf_token() }}">
            <div class="modal-body">
                <input type="hidden" id="invoice_ids" name="invoice_ids" />
                <em id="invoiceIdsError" class="invalid-feedback"></em>
                <p><label for="payment_type">{{ trans('cruds.payment.fields.payment_type') }}</label>
                    <select name="payment_type_id" id="payment_type" class="form-control select2">
                        @foreach($paymentTypes as $id => $paymentType)
                            <option value="{{ $id }}">{{ $paymentType }}</option>
                        @endforeach
                    </select>
                    <em id="paymentTypeError" class="invalid-feedback"></em>
                </p>
                <p><label for="entry_date">{{ trans('cruds.payment.fields.entry_date') }}*</label>
                    <input type="text" id="entry_date" name="entry_date" class="form-control date-picker" value="{{ old('entry_date') }}" placeholder="Select a date" required>
                    <em id="entryDateError" class="invalid-feedback"></em>
                </p>
                <p><strong>Total balance: </strong> <span id="modalTotalAmount">0.00</span></p>
                <p><textarea class="form-control h-150px" rows="6" id="description" name="description" ></textarea></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" id="confirmPayment">Confirm Payment</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

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
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.0/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        flatpickr("#entry_date", {
            dateFormat: "d-m-Y", // Adjust as needed
            allowInput: true
        });
    });
    function redirectToInvoice(invoiceId) {
        window.location = "{{ route('admin.invoices.show', '') }}/" + invoiceId;
    }
    // Prevent row click when clicking inside .no-click elements
    document.addEventListener("DOMContentLoaded", function () {
        document.querySelectorAll('.no-click').forEach(function (td) {
            td.addEventListener('click', function (event) {
                event.stopPropagation();
            });
        });
    });
    $(document).ready(function() {
        $('input[type="checkbox"]').prop('checked', false);
        let selectedInvoices = [];

        function updateTotals() {
            let totalAmount = selectedInvoices.reduce((sum, inv) => sum + parseFloat(inv.balance), 0);
            $("#totalAmount, #modalTotalAmount").text(totalAmount.toFixed(2));
            $("#makePaymentBtn").toggle(selectedInvoices.length > 0);  // Show/hide button
        }

        function updateInvoiceIds() {
            let selectedIds = [];
            $('input[type="checkbox"]:checked').each(function() {
                selectedIds.push($(this).data("id")); // Assuming the checkbox value is the invoice ID
            });
            $("#invoice_ids").val(selectedIds.join(",").replace(/^,|,$/g, ""));
        }


        $(".invoice-checkbox").change(function() {
            let balance = parseFloat($(this).data("balance"));

            if ($(this).is(":checked")) {
                selectedInvoices.push({ balance });
            } else {
                selectedInvoices = selectedInvoices.filter(inv => inv.balance !== balance);
            }

            // If all checkboxes are checked, mark #selectAll as checked, else uncheck it
            if ($(".invoice-checkbox").length === $(".invoice-checkbox:checked").length) {
                $("#selectAll").prop("checked", true);
            } else {
                $("#selectAll").prop("checked", false);
            }
            updateInvoiceIds(); 
            updateTotals();
        });

        $("#selectAll").change(function() {
            selectedInvoices = [];
            $(".invoice-checkbox").prop("checked", $(this).prop("checked")).trigger("change");
        });

        $("#makePaymentBtn").click(function() {
            $("#paymentModal").modal("show");
        });

        $("#confirmPayment").click(function() {
            let invoiceIds = $("#invoice_ids").val().trim();
            let paymentType = $("#payment_type").val().trim();
            let entryDate = $("#entry_date").val().trim();
            let description = $("#description").val();
            let isValid = true;

            // Reset previous error messages
            $(".invalid-feedback").text("").hide();
            $(".form-control").removeClass("is-invalid");

            // Basic validation
            if (invoiceIds === "") {
                $("#invoice_ids").addClass("is-invalid");
                $("#invoiceIdsError").text("Please select at least one invoice.").show();
                isValid = false;
            }
            if (paymentType === "") {
                $("#payment_type").addClass("is-invalid");
                $("#paymentTypeError").text("Payment type is required.").show();
                isValid = false;
            }
            if (entryDate === "") {
                $("#entry_date").addClass("is-invalid");
                $("#entryDateError").text("Entry date is required.").show();
                isValid = false;
            }

            if (!isValid) return; // Stop if validation fails

            let data = {
                'invoiceIds': invoiceIds,
                'paymentType': paymentType,
                'entryDate': entryDate,
                'description': description,
                _token: $('meta[name="csrf-token"]').attr('content') // CSRF token
            };
            $.ajax({
                url: "/admin/invoice/make-multi-payment",  // Update with your route
                type: "POST",
                data: data,
                beforeSend: function() {
                    $("#makePaymentBtn").prop("disabled", true).text("Processing...");
                },
                success: function(response) {
                    alert(response.message);
                    location.reload(); // Reload page after success
                },
                error: function(xhr) {
                    if (xhr.status === 422) { // Laravel validation error
                        let errors = xhr.responseJSON.errors;
                        if (errors.invoiceIds) {
                            $("#invoice_ids").addClass("is-invalid");
                            $("#invoiceIdsError").text(errors.invoiceIds[0]).show();
                        }
                        if (errors.paymentType) {
                            $("#payment_type").addClass("is-invalid");
                            $("#paymentTypeError").text(errors.paymentType[0]).show();
                        }
                        if (errors.entryDate) {
                            $("#entry_date").addClass("is-invalid");
                            $("#entryDateError").text(errors.entryDate[0]).show();
                        }
                    } else {
                        alert("Error: " + xhr.responseJSON.message);
                    }
                },
                complete: function() {
                    $("#makePaymentBtn").prop("disabled", false).text("Make Payment");
                }
            });

            $("#paymentModal").modal("hide");
        });
    });
    $(document).ready(function () {
        // Initialize Select2
        $('#supplier_id').select2({
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

        // Mark initialization as complete
        initialized = true;
    });
</script>


