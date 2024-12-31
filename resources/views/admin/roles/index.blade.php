@extends('layouts.admin')
@section('content')

<div class="content-body">
    <div class="row page-titles mx-0">
        @can('role_create')
                    <div style="margin-bottom: 10px;">
                        <a class="btn btn-success" href="{{ route('admin.roles.create') }}">
                            {{ trans('global.add') }} {{ trans('cruds.role.title_singular') }}
                        </a>
                    </div>
                @endcan
        <div class="col p-md-0">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="javascript:void(0)">Roles</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">List</a></li>
            </ol>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                

                <div class="card">
                    <h4 class="card-header">
                        {{ trans('cruds.role.title_singular') }} {{ trans('global.list') }}
                </h4>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover datatable datatable-Role">
                                <thead>
                                    <tr>
                                        <th width="10"></th>
                                        <!-- <th >{{ trans('cruds.role.fields.id') }}</th> -->
                                        <th>{{ trans('cruds.role.fields.title') }}</th>
                                        <th class="col-7">{{ trans('cruds.role.fields.permissions') }}</th>
                                        <th>&nbsp;</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($roles as $key => $role)
                                        <tr data-entry-id="{{ $role->id }}">
                                            <td></td>
                                            <!-- <td>{{ $role->id ?? '' }}</td> -->
                                            <td>{{ $role->title ?? '' }}</td>
                                            <td>
                                                @foreach($role->permissions as $key => $item)
                                                    <span class="badge badge-info">{{ $item->title }}</span>
                                                @endforeach
                                            </td>
                                            <td>
                                                @can('role_show')
                                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.roles.show', $role->id) }}">
                                                        {{ trans('global.view') }}
                                                    </a>
                                                @endcan

                                                @can('role_edit')
                                                    <a class="btn btn-xs btn-info" href="{{ route('admin.roles.edit', $role->id) }}">
                                                        {{ trans('global.edit') }}
                                                    </a>
                                                @endcan

                                                <!-- @can('role_delete')
                                                    <form action="{{ route('admin.roles.destroy', $role->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                                        <input type="hidden" name="_method" value="DELETE">
                                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                        <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                                                    </form>
                                                @endcan -->

                                                @can('role_delete')
                                                <form action="{{ route('admin.roles.destroy', $role->id) }}" method="POST" style="display: inline-block;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <input type="submit" class="btn btn-xs btn-danger delete-btn" value="{{ trans('global.delete') }}">
                                                        </form>
                                                @endcan

                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="pagination-wrapper">
                                {{ $roles->links('pagination::bootstrap-4') }} <!-- Bootstrap pagination style -->
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

@section('scripts')
@parent
<!-- <script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('role_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.roles.massDestroy') }}",
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
  $('.datatable-Role:not(.ajaxTable)').DataTable({ buttons: dtButtons })
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
            text: "Do you want to delete this Roles?",
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