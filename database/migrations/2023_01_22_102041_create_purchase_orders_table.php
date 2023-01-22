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
        Schema::create('purchase_orders', function (Blueprint $table) {
            $table->id();

            $table->string("po_number");
            $table->date("po_date");
            $table->string("po_description")->nullable();

            $table->integer("product_id");
            $table->integer("supplier_id")->default(0);
            $table->integer("category_id")->default(0);

            $table->double("purchase_qty")->default(0);
            $table->double("unit_price")->default(0);
            $table->double("purchase_price")->default(0);

            $table->tinyInteger("status_id")->default(0)->comment("0=Pending,1=Approved,2=Canceled");

            $table->integer("created_by")->nullable();
            $table->integer("updated_by")->nullable();

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
        Schema::dropIfExists('purchase_orders');
    }
};
