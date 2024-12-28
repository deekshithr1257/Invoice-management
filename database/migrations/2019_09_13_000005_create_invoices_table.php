<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesTable extends Migration
{
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('supplier_id')->unsigned()->nullable(false);
            $table->integer('store_id')->unsigned()->nullable(false);
            $table->string('invoice_number')->nullable(false);
            $table->date('entry_date')->nullable();
            $table->decimal('amount', 15, 2)->nullable();
            $table->decimal('balance', 15, 2)->nullable();
            $table->string('description')->nullable();
            $table->string('image')->nullable();
            $table->integer('created_by')->unsigned()->nullable(false);
            $table->timestamps();
            $table->softDeletes();
        
            // Add foreign keys if necessary
            $table->foreign('supplier_id')->references('id')->on('suppliers')->onDelete('cascade');
            $table->foreign('store_id')->references('id')->on('stores')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
        });
    }


    public function down()
    {
        Schema::dropIfExists('invoices');
    }
}
