<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('store_id');
            $table->date('entry_date');
            $table->decimal('cash', 15, 2)->default(0);
            $table->decimal('pay_out', 15, 2)->default(0);
            $table->decimal('pay_out_admin', 15, 2)->default(0);
            $table->decimal('cash_balance', 15, 2)->default(0);
            $table->decimal('card', 15, 2)->default(0);
            $table->text('description')->nullable();
            $table->unsignedInteger('created_by');
            $table->timestamps();
            $table->softDeletes();

            // Add a foreign key constraint for store_id if needed
            $table->foreign('store_id')->references('id')->on('stores')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sales');
    }
}
