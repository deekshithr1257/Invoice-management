<?php

namespace App\Http\Controllers\Admin;

use App\Store;
use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyStoreRequest;
use App\Http\Requests\StoreStoreRequest;
use App\Http\Requests\UpdateStoreRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class StoreController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('store_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
    
        // Use paginate() on the query builder, not on the collection
        $stores = Store::paginate(10);
    
        return view('admin.stores.index', compact('stores'));
    }

    public function create()
    {
        abort_if(Gate::denies('store_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.stores.create');
    }

    public function store(StoreStoreRequest $request)
    {
        $store = Store::create($request->all());
        $adminUserId = auth()->id();
        $store->users()->sync($adminUserId);
        return redirect()->route('admin.stores.index');
    }

    public function edit(Store $store)
    {
        abort_if(Gate::denies('store_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.stores.edit', compact('store'));
    }

    public function update(UpdateStoreRequest $request, Store $store)
    {
        $store->update($request->all());

        return redirect()->route('admin.stores.index');
    }

    public function show(Store $store)
    {
        abort_if(Gate::denies('store_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        return view('admin.stores.show', compact('store'));
    }

    public function destroy(Store $store)
    {
        abort_if(Gate::denies('store_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $store->delete();

        return back();
    }

    public function massDestroy(MassDestroyStoreRequest $request)
    {
        Store::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
    
    public function setStore(Request $request)
    {
        $storeId = $request->input('store_id');
        session(['selected_store_id' => $storeId]);

        return redirect()->route('admin.dashboard.index');
    }
}
