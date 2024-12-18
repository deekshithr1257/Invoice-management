<?php

namespace App\Http\Controllers\Admin;

use App\InvoiceCategory;
use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyInvoiceCategoryRequest;
use App\Http\Requests\StoreInvoiceCategoryRequest;
use App\Http\Requests\UpdateInvoiceCategoryRequest;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DashboardController extends Controller
{
    public function index()
    {
        // abort_if(Gate::denies('dashboard_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.dashboard.index');
    }
}
