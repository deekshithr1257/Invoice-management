@extends('layouts.admin')
@section('content')


<div class="content-body">
    <div class="row page-titles mx-0">
        @can('invoice_create')
            <div style="margin-bottom: 10px;" class="row">
                <div class="col-lg-12">
                    <a class="btn btn-success" href="{{ route("admin.invoices.create") }}">
                        {{ trans('global.add') }} {{ trans('cruds.invoice.title_singular') }}
                    </a>
                </div>
            </div>
        @endcan
        <div class="col p-md-0">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Home</a></li>
            </ol>
        </div>
    </div>
    <!-- row -->

    <div class="container-fluid">
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
                                        <td>{{ $invoice->entry_date ?? '' }}</td>
                                        <td>{{ $invoice->amount ?? '' }}</td>
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
@endsection
@section('scripts')
@parent
<!-- <script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('invoice_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.invoices.massDestroy') }}",
    className: 'btn-danger',
    action: function (e, dt, node, config) {
      var ids = $.map(dt.rows({ selected: true }).nodes(), function (entry) {
          return $(entry).data('entry-id')
      });

      if (ids.length === 0) {
        alert('{{ trans('global.datatables.zero_selected') }}')

        return
      }

      if (confirm('{{ trans('global.areYouSure') }}')) {
        $.ajax({
          headers: {'x-csrf-token': _token},
          method: 'POST',
          url: config.url,
          data: { ids: ids, _method: 'DELETE' }})
          .done(function () { location.reload() })
      }
    }
  }
  dtButtons.push(deleteButton)
@endcan

  $.extend(true, $.fn.dataTable.defaults, {
    order: [[ 1, 'desc' ]],
    pageLength: 100,
  });
  $('.datatable-Invoice:not(.ajaxTable)').DataTable({ buttons: dtButtons })
    $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
        $($.fn.dataTable.tables(true)).DataTable()
            .columns.adjust();
    });
})

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
