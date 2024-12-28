<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('invoice_id')->unsigned()->nullable(false);
            $table->integer('payment_type_id')->unsigned()->nullable(false);
            $table->integer('store_id')->unsigned()->nullable(false);
            $table->date('entry_date')->nullable(false);
            $table->decimal('amount', 15, 2)->nullable(false);
            $table->string('description')->nullable();
            $table->integer('created_by')->unsigned()->nullable(false);
            $table->timestamps();
            $table->softDeletes();
        
            // Foreign key constraints
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('invoice_id')->references('id')->on('invoices')->onDelete('cascade');
            $table->foreign('payment_type_id')->references('id')->on('payment_types')->onDelete('cascade');
            $table->foreign('store_id')->references('id')->on('stores')->onDelete('cascade');
        });
        
    }
}
