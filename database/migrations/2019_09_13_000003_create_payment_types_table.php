<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentTypesTable extends Migration
{
    public function up()
    {
        Schema::create('payment_types', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable(false); // Payment type name
            $table->integer('created_by')->unsigned()->nullable(false); // User ID who created the payment type
            $table->timestamps();
            $table->softDeletes();
        
            // Foreign key constraint
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
        });        
    }
}
