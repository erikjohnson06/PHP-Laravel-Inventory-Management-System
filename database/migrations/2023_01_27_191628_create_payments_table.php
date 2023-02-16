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
            $table->integer("invoice_id")->default(0);
            $table->integer("customer_id")->default(0);
            $table->date("payment_date")->nullable();
            $table->tinyInteger("status_id")->default(0)->comment("1=Paid in Full, 2 = Due Amount Payment, 3 = Partial Payment");
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
