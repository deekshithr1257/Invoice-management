<?php

Route::redirect('/', '/login');
Route::redirect('/home', '/admin/dashboard');
Auth::routes();

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Admin', 'middleware' => ['auth']], function () {
    Route::redirect('/', '/admin/dashboard');

    //Dashboard
    Route::get('dashboard', 'DashboardController@index')->name('dashboard.index');

    // Permissions
    Route::delete('permissions/destroy', 'PermissionsController@massDestroy')->name('permissions.massDestroy');
    Route::resource('permissions', 'PermissionsController');

    // Roles
    Route::delete('roles/destroy', 'RolesController@massDestroy')->name('roles.massDestroy');
    Route::resource('roles', 'RolesController');

    // Users
    Route::delete('users/destroy', 'UsersController@massDestroy')->name('users.massDestroy');
    Route::resource('users', 'UsersController');

    // Suppliers
    Route::delete('suppliers/destroy', 'SupplierController@massDestroy')->name('suppliers.massDestroy');
    Route::resource('suppliers', 'SupplierController');

    // Suppliers
    Route::delete('stores/destroy', 'StoreController@massDestroy')->name('stores.massDestroy');
    Route::resource('stores', 'StoreController');
 
     // Paymentcategories
    Route::delete('payment-types/destroy', 'PaymentTypeController@massDestroy')->name('payment-types.massDestroy');
    Route::resource('payment-types', 'PaymentTypeController');

    // Invoices
    Route::delete('invoices/destroy', 'InvoiceController@massDestroy')->name('invoices.massDestroy');
    Route::resource('invoices', 'InvoiceController');
    Route::get('download-invoice/{imageName}', 'InvoiceController@downloadInvoice')->name('invoices.download');

    // Payments
    Route::delete('payments/destroy', 'PaymentController@massDestroy')->name('payments.massDestroy');
    Route::resource('payments', 'PaymentController');

    // Invoicereports
    Route::delete('invoice-reports/destroy', 'InvoiceReportController@massDestroy')->name('invoice-reports.massDestroy');
    Route::resource('invoice-reports', 'InvoiceReportController');

    Route::post('set-store', 'StoreController@setStore')->name('set.store');
});
