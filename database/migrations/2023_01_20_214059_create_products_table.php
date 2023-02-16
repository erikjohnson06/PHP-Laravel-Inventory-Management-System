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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string("name")->nullable();
            $table->integer("supplier_id");
            $table->integer("unit_id");
            $table->integer("category_id");
            $table->double("quantity")->nullable()->default(0);
            $table->tinyInteger("status_id")->default(1)->comment("1 = Active, 2 = Closeout, 3 = On Hold, 4 = Inactive");
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
        Schema::dropIfExists('products');
    }
};
