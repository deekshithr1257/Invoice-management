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

    // Invoicecategories
    Route::delete('invoice-categories/destroy', 'InvoiceCategoryController@massDestroy')->name('invoice-categories.massDestroy');
    Route::resource('invoice-categories', 'InvoiceCategoryController');

    // Vendors
    Route::delete('vendors/destroy', 'VendorController@massDestroy')->name('vendors.massDestroy');
    Route::resource('vendors', 'VendorController');

    // Paymentcategories
    Route::delete('payment-categories/destroy', 'PaymentCategoryController@massDestroy')->name('payment-categories.massDestroy');
    Route::resource('payment-categories', 'PaymentCategoryController');

    // Invoices
    Route::delete('invoices/destroy', 'InvoiceController@massDestroy')->name('invoices.massDestroy');
    Route::resource('invoices', 'InvoiceController');

    // Payments
    Route::delete('payments/destroy', 'PaymentController@massDestroy')->name('payments.massDestroy');
    Route::resource('payments', 'PaymentController');

    // Invoicereports
    Route::delete('invoice-reports/destroy', 'InvoiceReportController@massDestroy')->name('invoice-reports.massDestroy');
    Route::resource('invoice-reports', 'InvoiceReportController');
});
