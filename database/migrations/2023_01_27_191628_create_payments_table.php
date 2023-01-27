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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->integer("invoice_id")->nullable();
            $table->integer("customer_id")->nullable();
            $table->date("payment_date")->nullable();
            $table->string("status_id", 51)->nullable();
            $table->double("payment_amount")->default(0)->nullable();
            $table->double("discount_amount")->default(0)->nullable();
            $table->double("due_amount")->default(0)->nullable();
            $table->double("total_amount")->default(0)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payments');
    }
};