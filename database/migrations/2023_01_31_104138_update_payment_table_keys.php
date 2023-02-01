<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table("payment_details", function (Blueprint $table) {
            $table->foreign('invoice_id')
              ->references('invoice_no')->on('invoices')->onDelete('restrict');
        });

        Schema::table("payments", function (Blueprint $table) {
            $table->foreign('invoice_id')
              ->references('invoice_no')->on('invoices')->onDelete('restrict');

            $table->foreign('customer_id')
              ->references('id')->on('customers')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
