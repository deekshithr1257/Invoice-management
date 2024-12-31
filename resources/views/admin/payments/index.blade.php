@extends('layouts.admin')
@section('content')

<div class="content-body">
    <div class="row page-titles mx-0">
    @can('payment_create')
        <div style="margin-bottom: 10px;" class="row">
            <div class="col-lg-12">
                <a class="btn btn-success" href="{{ route('admin.payments.create') }}">
                    {{ trans('global.add') }} {{ trans('cruds.payment.title_singular') }}
                </a>
            </div>
        </div>
        @endcan
        <div class="col p-md-0">
            <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.payments.index') }}">{{ trans('cruds.payment.title_singular') }}</a></li>
                <li class="breadcrumb-item active">{{ trans('global.list') }} {{ trans('cruds.payment.title_singular') }}</li>
            </ol>
        </div>
    </div>

    <div class="container-fluid">
    <div class="row">
        <div class="col d-flex justify-content-end pe-5">
            <form method="get">
                <div class="row">
                    <!-- Month Dropdown -->
                    <div class="col-md-6 form-group">
                        <label class="control-label" for="m">{{ trans('global.month') }}</label>
                        <select name="m" id="m" class="form-control">
                            @foreach(cal_info(0)['months'] as $month)
                                <option value="{{ $month }}" @if($month === old('m', Request::get('m', date('m')))) selected @endif>
                                    {{ $month }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Submit Button -->
                    <div class="col-md-2 filter-button-container">
                        <label class="control-label">&nbsp;</label><br>
                        <button class="btn btn-primary" type="submit">{{ trans('global.filterDate') }}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

        <div class="card">
            <h4 class="card-header">
                {{ trans('cruds.payment.title_singular') }} {{ trans('global.list') }}
            </h4>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover datatable datatable-Payment">
                        <thead>
                            <tr>
                                <th width="10"></th>
                                <!-- <th>{{ trans('cruds.payment.fields.id') }}</th> -->
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
                                    <td></td>
                                    <!-- <td>{{ $payment->id ?? '' }}</td> -->
                                    <td>{{ $payment->invoice ? $payment->invoice->invoice_number : '' }}</td>
                                    <td>{{ $payment->payment_type->name ?? '' }}</td>
                                    <td>{{ $payment->entry_date ?? '' }}</td>
                                    <td>{{ $payment->amount ?? '' }}</td>
                                    <!-- <td> -->
                                        <!-- @can('payment_show')
                                            <a class="btn btn-xs btn-primary" href="{{ route('admin.payments.show', $payment->id) }}">
                                                {{ trans('global.view') }}
                                            </a>
                                        @endcan

                                        @can('payment_edit')
                                            <a class="btn btn-xs btn-info" href="{{ route('admin.payments.edit', $payment->id) }}">
                                                {{ trans('global.edit') }}
                                            </a>
                                        @endcan -->

                                        <!-- @can('payment_delete')
                                        <button class="btn btn-xs btn-danger delete-payment" data-id="{{ $payment->id }}">
                                            {{ trans('global.delete') }}
                                        </button>
                                         @endcan -->

                                         <!-- @can('payment_delete')
                                                <form action="{{ route('admin.payments.destroy', $payment->id) }}" method="POST" style="display: inline-block;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <input type="submit" class="btn btn-xs btn-danger delete-btn" value="{{ trans('global.delete') }}">
                                                        </form>
                                                @endcan -->

                                    <!-- </td> -->
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