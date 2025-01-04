@extends('layouts.admin')
@section('content')

<div class="content-body">
    <div class="row page-titles mx-0">
    @can('payment_create')
        
            <div class="col-lg-6 col-md-6 d-flex align-items-center mb-2 mb-lg-0">
                <a class="btn btn-success" href="{{ route('admin.payments.create') }}">
                    {{ trans('global.add') }} {{ trans('cruds.payment.title_singular') }}
                </a>
            </div>

        @endcan
        <div  class="col-lg-6 col-md-6 d-flex align-items-center justify-content-end">
        <!-- Filter Form -->
        <form method="GET" action="{{ route('admin.payments.index') }}" class="form-inline w-100">
            <div class="form-group mb-0 w-100">
                    <select name="invoice_id" id="invoice_id" class="header-select form-control" data-selected="{{ $invoice_id }}">
                        <option value="0" {{ $invoice_id == 0 ? 'selected' : '' }}>All</option>
                        @foreach($invoices as $invoice)
                            <option value="{{ $invoice->id }}" {{ $invoice_id == $invoice->id ? 'selected' : '' }}>
                            {{ $invoice->invoice_number }}
                            </option>
                        @endforeach
                    </select>
            </div>
        </form>
    </div>
        <!-- <div class="col p-md-0">
            <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.payments.index') }}">{{ trans('cruds.payment.title_singular') }}</a></li>
                <li class="breadcrumb-item active">{{ trans('global.list') }} {{ trans('cruds.payment.title_singular') }}</li>
            </ol>
        </div> -->
    </div>

    <div class="container-fluid">
    <!-- <div class="row">
        <div class="col d-flex justify-content-end pe-5">
            <form method="GET" action="{{ route('admin.payments.index') }}" class="form-inline">
                <select name="invoice_id" id="invoice_id" class="header-select" onchange="this.form.submit()">
                    <option value="0" {{ $invoice_id == 0 ? 'selected':""}}>All</option>
                    @foreach($invoices as $invoice)
                        <option value="{{ $invoice->id }}" {{ $invoice_id == $invoice->id ? 'selected':""}}>
                            {{ $invoice->invoice_number }}
                        </option>
                    @endforeach
                </select>
            </form>
        </div>
    </div> -->

        <div class="card">
            <h4 class="card-header">
                {{ trans('cruds.payment.title_singular') }} {{ trans('global.list') }}
            </h4>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover datatable datatable-Payment">
                        <thead>
                            <tr>
                                <th>{{ trans('cruds.payment.fields.invoice_number') }}</th>
                                <th>{{ trans('cruds.payment.fields.payment_type') }}</th>
                                <th>{{ trans('cruds.payment.fields.entry_date') }}</th>
                                <th>{{ trans('cruds.payment.fields.amount') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($payments as $payment)
                                <tr data-entry-id="{{ $payment->id }}" onclick="window.location='{{ route('admin.payments.show', $payment->id) }}';" 
                                style="cursor: pointer;">
                                    <td>{{ $payment->invoice ? $payment->invoice->invoice_number : '' }}</td>
                                    <td>{{ $payment->payment_type->name ?? '' }}</td>
                                    <td>{{ $payment->entry_date ?? '' }}</td>
                                    <td>{{ $payment->amount ?? '' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                        <!-- Pagination Links -->
                        <div class="pagination-wrapper">
                            {{ $payments->links('pagination::bootstrap-4') }} <!-- Bootstrap pagination style -->
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
@parent
<!-- <script>
    $(function () {
        // Initialize DataTable with delete button functionality
        let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons);
        @can('payment_delete')
        let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
        let deleteButton = {
            text: deleteButtonTrans,
            url: "{{ route('admin.payments.massDestroy') }}",
            className: 'btn-danger',
            action: function (e, dt, node, config) {
                var ids = $.map(dt.rows({ selected: true }).nodes(), function (entry) {
                    return $(entry).data('entry-id');
                });

                if (ids.length === 0) {
                    Swal.fire({
                        title: '{{ trans('global.datatables.zero_selected') }}',
                        icon: 'info',
                        confirmButtonText: 'OK',
                    });
                    return;
                }

                Swal.fire({
                    title: 'Are you sure You Want To delete it?',
                    text: "This action cannot be undone.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'Cancel',
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            headers: { 'x-csrf-token': _token },
                            method: 'POST',
                            url: config.url,
                            data: { ids: ids, _method: 'DELETE' },
                        })
                        .done(function () {
                            Swal.fire(
                                'Deleted!',
                                'Your record(s) have been deleted.',
                                'success'
                            ).then(() => location.reload());
                        })
                        .fail(function () {
                            Swal.fire('Error!', 'Something went wrong. Please try again.', 'error');
                        });
                    }
                });
            }
        };
        dtButtons.push(deleteButton);
        @endcan

        // DataTable Initialization
        $.extend(true, $.fn.dataTable.defaults, {
            order: [[1, 'desc']],
            pageLength: 100,
        });
        $('.datatable-Payment:not(.ajaxTable)').DataTable({ buttons: dtButtons });

        // SweetAlert for Individual Delete Button
        $(document).on('click', '.delete-payment', function (e) {
            e.preventDefault();
            let id = $(this).data('id');
            Swal.fire({
                title: 'Are you sure?',
                text: "This action cannot be undone.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel',
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('admin.payments.destroy', '') }}/" + id,
                        method: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            _method: 'DELETE',
                        },
                    })
                    .done(function () {
                        Swal.fire('Deleted!', 'The record has been deleted.', 'success')
                            .then(() => location.reload());
                    })
                    .fail(function () {
                        Swal.fire('Error!', 'Something went wrong. Please try again.', 'error');
                    });
                }
            });
        });

        // Adjust DataTables on Tab Change
        $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
            $($.fn.dataTable.tables(true)).DataTable().columns.adjust();
        });
    });
</script> -->
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
        width: 425px; /* Set a fixed width for desktop */
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
    $('#invoice_id').select2({
        placeholder: "All", // Ensure the placeholder says "All"
        allowClear: true, // Allow clearing
        width: 'resolve', // Adjust dropdown width
    });

    // Prevent form submission during initialization
    let initialized = false;

    $('#invoice_id').on('change', function () {
        if (initialized) {
            this.form.submit(); // Submit the form only after initialization is complete
        }
    });

    // Set the selected value to "All" if none is selected or based on server-side data
    var selectedValue = $('#invoice_id').data('selected'); // Get selected value from a data attribute
    if (!selectedValue || selectedValue === "0") {
        $('#invoice_id').val("0").trigger('change.select2'); // Set "All" as the default
    } else {
        $('#invoice_id').val(selectedValue).trigger('change.select2'); // Set the server-provided value
    }

    // Mark initialization as complete
    initialized = true;
});
</script>

<script>
    // Attach the `myDelete` function to all delete buttons once the page is loaded
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.delete-btn').forEach(function(button) {
            button.addEventListener('click', myDelete);  // Add click event to each delete button
        });
    });

    // JavaScript function to handle the deletion process
    function myDelete(ev) {
        ev.preventDefault(); // Prevent the default form submission
        console.log('Delete button clicked');  // This will log when the button is clicked
        var form = ev.currentTarget.closest('form');
        
        Swal.fire({
            title: 'Are you sure?',
            text: "Do you want to delete this Payment?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'No, cancel!',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                console.log('Form will be submitted'); // This will log if the form is confirmed for submission
                form.submit();
            }
        });
    }
</script>