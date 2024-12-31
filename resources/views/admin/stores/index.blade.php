@extends('layouts.admin')
@section('content')

<div class="content-body">

    <div class="row page-titles mx-0">
    @can('store_create')
            <div style="margin-bottom: 10px;" class="row">
                <div class="col-lg-12">
                    <a class="btn btn-success" href="{{ route("admin.stores.create") }}">
                        {{ trans('global.add') }} {{ trans('cruds.store.title_singular') }}
                    </a>
                </div>
            </div>
        @endcan
        <div class="col p-md-0">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">{{ trans('cruds.store.title_singular') }}</a></li>
            </ol>
        </div>
    </div>

    <div class="container-fluid">
        

        <div class="card">
            <h4 class="card-header">
                {{ trans('cruds.store.title_singular') }} {{ trans('global.list') }}
            </h4>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover datatable datatable-Supplier">
                        <thead>
                            <tr>
                                <th>{{ trans('cruds.store.fields.name') }}</th>
                                <th>{{ trans('cruds.store.fields.email') }}</th>
                                <th>{{ trans('cruds.store.fields.contact_number') }}</th>
                                <th>&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($stores as $key => $store)
                                <tr data-entry-id="{{ $store->id }}">
                                    <td>{{ $store->name ?? '' }}</td>
                                    <td>{{ $store->email ?? '' }}</td>
                                    <td>{{ $store->contact_number ?? '' }}</td>
                                    <td>
                                        @can('store_show')
                                            <a class="btn btn-xs btn-primary" href="{{ route('admin.stores.show', $store->id) }}">
                                                {{ trans('global.view') }}
                                            </a>
                                        @endcan

                                        @can('store_edit')
                                            <a class="btn btn-xs btn-info" href="{{ route('admin.stores.edit', $store->id) }}">
                                                {{ trans('global.edit') }}
                                            </a>
                                        @endcan

                                        <!-- @can('store_delete')
                                            <form action="{{ route('admin.stores.destroy', $store->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                                <input type="hidden" name="_method" value="DELETE">
                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                                            </form>
                                        @endcan -->

                                                @can('permission_delete')
                                                        <form action="{{ route('admin.stores.destroy', $store->id) }}" method="POST" style="display: inline-block;">
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
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
@parent
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
            text: "Do you want to delete this Suppliers?",
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