<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToInvoicesTable extends Migration
{
    public function up()
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->unsignedInteger('invoice_category_id')->nullable();

            $table->foreign('invoice_category_id', 'invoice_category_fk_334989')->references('id')->on('invoice_categories');

            $table->unsignedInteger('created_by_id')->nullable();

            $table->foreign('created_by_id', 'created_by_fk_335008')->references('id')->on('users');
        });
    }
}
