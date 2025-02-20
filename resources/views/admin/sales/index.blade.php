@extends('layouts.admin')
@section('content')

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<style>
   
    @media (max-width: 427px) {
        .row {
            padding: 0.9375rem 0.175rem;
        }
        .btn {
            padding: 2px 18px !important;
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
    <div class="row page-titles mx-0">
        @can('sale_create')
        
            <div class="d-flex align-items-center mb-lg-0">
                <a class="btn btn-success" href="{{ route('admin.sales.create') }}">
                    Add
                </a>
            </div>
        @endcan
        @if($totalCashBalance>0)
            @can('sale_cash_collection_access')
                <div class="col-lg-3 col-md-3 d-flex align-items-center mb-lg-0">
                    <button id="collectCash" class="btn btn-primary">
                        Collect Cash
                    </button>
                </div>
            @endcan
        @endif
        <div  class="col-lg-6 col-md-6 d-flex align-items-center justify-content-end">
            <!-- Filter Form -->
        </div>
    </div>

    <div class="container-fluid">
        <div class="card">
            <h4 class="card-header">
                {{ trans('cruds.sales.title_singular') }} {{ trans('global.list') }}
            </h4>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover datatable datatable-Payment">
                        <thead>
                            <tr>
                                <th>{{ trans('cruds.sales.fields.entry_date') }}</th>
                                <th>{{ trans('cruds.sales.fields.cash_sales') }}</th>
                                <th>{{ trans('cruds.sales.fields.card_sales') }}</th>
                                <th>{{ trans('cruds.sales.fields.total') }}</th>
                                <th>{{ trans('cruds.sales.fields.pay_out') }}</th>
                                <th>{{ trans('cruds.sales.fields.cash_balance') }}</th>
                                <th>{{ trans('cruds.sales.fields.pay_out_admin') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $grandTotal = 0;
                            @endphp
                            @foreach($sales as $sale)
                                @php
                                    $total = $sale->card + $sale->cash;
                                    $grandTotal += $total;
                                @endphp
                                <tr data-entry-id="{{ $sale->id }}" onclick="window.location='{{ route('admin.sales.show', $sale->id) }}';" 
                                style="cursor: pointer;">
                                    <td>{{ \Carbon\Carbon::parse($sale->entry_date)->format('d/m/Y') ?? '' }}</td>
                                    <td style="text-align: right;"> {{ ($sale->cash && $sale->cash !=0) ? $sale->cash : '' }}</td>
                                    <td style="text-align: right;"> {{ ($sale->card && $sale->card !=0) ? $sale->card : '' }}</td>
                                    <td style="text-align: right;"> {{ ($total!=0) ? number_format($total, 2, '.', '') : '' }}</td>
                                    <td style="text-align: right;"> {{ ($sale->pay_out && $sale->pay_out !=0) ? $sale->pay_out : '' }}</td>
                                    <td style="text-align: right;"> {{ ($sale->cash_balance && $sale->cash_balance !=0) ? $sale->cash_balance : '' }}</td>
                                    <td style="text-align: right;"> {{ ($sale->pay_out_admin && $sale->pay_out_admin !=0) ? $sale->pay_out_admin : '' }}</td>
                                </tr>
                            @endforeach
                                <tr>
                                    <th style="text-align: left;">{{ trans('cruds.sales.fields.total') }} (including all sales across all pages)</th>
                                    <th style="text-align: right;">{{ $totalCash }}</th>
                                    <th style="text-align: right;">{{ $totalCard }}</th>
                                    <th style="text-align: right;">{{ number_format($grandTotal, 2, '.', '') }}</th>
                                    <th style="text-align: right;">{{ $totalPayOut }}</th>
                                    <th style="text-align: right;"> {{ $balanceCash }}</th>
                                    <th style="text-align: right;"> {{ $totalCashCollectedByAdmin }}</th>
                                </tr>
                        </tbody>
                    </table>
                        <!-- Pagination Links -->
                        <div class="pagination-wrapper">
                            {{ $sales->links('pagination::bootstrap-4') }} <!-- Bootstrap pagination style -->
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="cashCollectModal" class="modal fade" tabindex="-1" role="dialog" style="display: none;">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Pay Out Admin</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <meta name="csrf-token" content="{{ csrf_token() }}">
            <div class="modal-body">
                <div class="form-group {{ $errors->has('entry_date') ? 'has-error' : '' }}">
                    <label for="entry_date">{{ trans('cruds.sales.fields.entry_date') }}*</label>
                    <input type="text" id="entry_date" name="entry_date" class="form-control date-picker" value="{{ old('entry_date') }}" placeholder="Select a date" required>
                    @if($errors->has('entry_date'))
                        <em class="invalid-feedback">
                            {{ $errors->first('entry_date') }}
                        </em>
                    @endif
                    <p class="helper-block">
                        {{ trans('cruds.sales.fields.entry_date_helper') }}
                    </p>
                </div>
            
                <p><label for="collected_cash">{{ trans('cruds.sales.fields.cash') }}*</label>
                    <input type="hidden" id="total_cash_balance" name="total_cash_balance" class="form-control" value="{{ $balanceCash }}" step="0.01" required>
                    <input type="number" id="collected_cash" name="collected_cash" class="form-control" value="{{ $balanceCash }}" step="0.01" required>
                    <em id="collectedCashError" class="invalid-feedback"></em>
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" id="confirm">Confirm</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endsection

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        flatpickr("#entry_date", {
            dateFormat: "d-m-Y", // Adjust as needed
            allowInput: true
        });
    });
    $(document).ready(function() {
        $("#collectCash").click(function() {
            $("#cashCollectModal").modal("show");
        });

        $("#confirm").click(function() {
            let entryDate = $("#entry_date").val();
            let collectedCash = parseFloat($("#collected_cash").val()).toFixed(2);
            let totalCashBalance = parseFloat($("#total_cash_balance").val()).toFixed(2);
            let isValid = true;
            // Reset previous error messages
            $(".invalid-feedback").text("").hide();
            $(".form-control").removeClass("is-invalid");

            // Basic validation
            if (collectedCash <= 0) {
                $("#collected_cash").addClass("is-invalid");
                $("#collectedCashError").text("Please enter proper amount.").show();
                isValid = false;
            }
            if (collectedCash > totalCashBalance) {
                $("#collected_cash").addClass("is-invalid");
                $("#collectedCashError").text("The amount cannot exceed the available cash balance of £ "+totalCashBalance+" .").show();
                isValid = false;
            }
            if (!isValid) return;

            let data = {
                'collectedCash': collectedCash,
                'entryDate': entryDate,
                _token: $('meta[name="csrf-token"]').attr('content') // CSRF token
            };
            $.ajax({
                url: "/admin/sales/collect-cash",  // Update with your route
                type: "POST",
                data: data,
                beforeSend: function() {
                    $("#collectCash").prop("disabled", true).text("Processing...");
                },
                success: function(response) {
                    alert(response.message);
                    $("#cashCollectModal").modal("hide");
                    location.reload(); // Reload page after success
                },
                error: function(xhr) {
                    if (xhr.status === 422) { // Laravel validation error
                        let errors = xhr.responseJSON.errors;
                        if (errors.collectedCash) {
                            $("#collected_cash").addClass("is-invalid");
                            $("#collectedCashError").text(errors.collectedCash[0]).show();
                        }
                    } else {
                        alert("Error: " + xhr.responseJSON.message);
                    }
                },
                complete: function() {
                    $("#collectCash").prop("disabled", false).text("Collect Cash");
                }
            });

        });
    });
</script>