<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoiceImagesTable extends Migration
{
    public function up()
    {
        Schema::create('invoice_images', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->unsignedInteger('invoice_id'); // Foreign key to invoices table
            $table->string('image_path'); // Path to the image
            $table->string('image_name')->nullable(); // Optional image name
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('invoice_id')->references('id')->on('invoices')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('invoice_images');
    }
}

