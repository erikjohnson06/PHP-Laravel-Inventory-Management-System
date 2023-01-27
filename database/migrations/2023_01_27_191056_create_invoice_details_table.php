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
        Schema::create('invoice_details', function (Blueprint $table) {
            $table->id();
            $table->integer("invoice_id")->nullable();
            $table->date("invoice_date")->nullable();
            $table->integer("category_id")->nullable();
            $table->integer("product_id")->nullable();
            $table->double("sales_qty")->default(0)->nullable();
            $table->double("unit_price")->default(0)->nullable();
            $table->double("sales_price")->default(0)->nullable();
            $table->tinyInteger("status_id")->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoice_details');
    }
};
