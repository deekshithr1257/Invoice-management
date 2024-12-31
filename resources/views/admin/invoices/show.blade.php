@extends('layouts.admin')

@section('content')
<div class="content-body">
    <div class="row page-titles mx-0">
        <div class="col p-md-0">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.invoices.index') }}">Invoices</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Show</a></li>
            </ol>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        {{ trans('global.show') }} {{ trans('cruds.invoice.title') }}
                    </div>

                    <div class="card-body">
                        <div class="mb-2">
                            <table class="table table-bordered table-striped">
                                <tbody>
                                    <tr>
                                        <th>
                                            {{ trans('cruds.invoice.fields.id') }}
                                        </th>
                                        <td>
                                            {{ $invoice->id }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            {{ trans('cruds.invoice.fields.invoice_number') }}
                                        </th>
                                        <td>
                                            {{ $invoice->invoice_number?? '' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            {{ trans('cruds.invoice.fields.entry_date') }}
                                        </th>
                                        <td>
                                            {{ $invoice->entry_date }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            {{ trans('cruds.invoice.fields.supplier') }}
                                        </th>
                                        <td>
                                            {{ $invoice->supplier->name }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            {{ trans('cruds.invoice.fields.store') }}
                                        </th>
                                        <td>
                                            {{ $invoice->store->name }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            {{ trans('cruds.invoice.fields.description') }}
                                        </th>
                                        <td>
                                            {{ $invoice->description }}
                                        </td>
                                        
                                    </tr>
                                    <tr>
                                        <th>
                                            {{ trans('cruds.invoice.fields.amount') }}
                                        </th>
                                        <td>
                                            <i class="fa fa-pound-sign"></i>{{ number_format($invoice->amount, 2) }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            {{ trans('cruds.invoice.fields.balance') }}
                                        </th>
                                        <td>
                                            <i class="fa fa-pound-sign"></i>{{ number_format($invoice->balance, 2) }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            {{ trans('cruds.invoice.fields.description') }}
                                        </th>
                                        <td>
                                            {{ $invoice->description }}
                                        </td>
                                        
                                    </tr>
                                    <tr>
                                        <th>
                                            {{ trans('cruds.invoice.fields.invoice') }}
                                        </th>
                                        <td>
                                            <div class="text-center">
                                                <!-- Download Link with Icon -->
                                                <a href="{{ route('admin.invoices.download', basename($invoice->image)) }}" 
                                                class="d-inline-flex align-items-center mb-3 text-decoration-none text-primary">
                                                    <i class="fas fa-download me-2" style="font-size: 18px;"></i>
                                                    Download
                                                </a>
                                                <!-- Invoice Image -->
                                                <div class="d-flex justify-content-center align-items-center mt-2">
                                                    <img src="{{ asset('storage/'.$invoice->image) }}" alt="invoice" class="img-fluid responsive-image">
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Action</th>
                                        <td>
                                            @can('invoice_edit')
                                                <a class="btn btn-xs btn-info mt-1 mt-md-0" href="{{ route('admin.invoices.edit', $invoice->id) }}">
                                                    {{ trans('global.edit') }}
                                                </a>
                                            @endcan
                                            @can('invoice_payment')
                                                <a class="btn btn-xs btn-success mt-2 mt-md-0" href="{{ route('admin.invoices.payment.get', $invoice->id) }}">
                                                    Payment
                                                </a>
                                            @endcan
                                            @can('invoice_delete')
                                                <form action="{{ route('admin.invoices.destroy', $invoice->id) }}" method="POST" style="display: inline-block;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <input type="submit" class="btn btn-xs btn-danger mt-1 mt-md-0 delete-btn" value="{{ trans('global.delete') }}">
                                                </form>
                                            @endcan
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <a href="{{ url()->previous() }}" class="btn btn-secondary" style="margin-top: 20px;">
                                {{ trans('global.back_to_list') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<style>
    /* Restrict image size on larger screens */
    @media (min-width: 992px) {
        .responsive-image {
            max-width: 400px; /* Adjust the maximum width as needed */
            max-height: 400px; /* Optional: Set a maximum height */
        }
    }
</style>
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
            text: "Do you want to delete this Invoice?",
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
