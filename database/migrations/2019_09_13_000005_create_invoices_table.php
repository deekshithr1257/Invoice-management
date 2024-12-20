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

            $table->date('entry_date')->nullable();

            $table->decimal('amount', 15, 2)->nullable();

            $table->string('description')->nullable();

            $table->string('image')->nullable();

            $table->string('camera_image')->nullable(); // For camera-captured image

            $table->timestamps();

            $table->softDeletes();
        });
    }
}
