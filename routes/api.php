<?php

Route::group(['prefix' => 'v1', 'as' => 'api.', 'namespace' => 'Api\V1\Admin', 'middleware' => ['auth:api']], function () {
    // Permissions
    Route::apiResource('permissions', 'PermissionsApiController');

    // Roles
    Route::apiResource('roles', 'RolesApiController');

    // Users
    Route::apiResource('users', 'UsersApiController');

    // Invoicecategories
    Route::apiResource('invoice-categories', 'InvoiceCategoryApiController');

    // Paymentcategories
    Route::apiResource('payment-categories', 'PaymentCategoryApiController');

    // Invoices
    Route::apiResource('invoices', 'InvoiceApiController');

    // Payments
    Route::apiResource('payments', 'PaymentApiController');

    // Invoicereports
    Route::apiResource('invoice-reports', 'InvoiceReportApiController');
});
