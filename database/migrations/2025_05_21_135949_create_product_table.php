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
        Schema::create('product', function (Blueprint $table) {
            $table->id();
            $table->integer('product_category');
            $table->string('product_name');
            $table->string('product_image');
            $table->string('product_price');
            $table->string('product_type');
            $table->string('product_specification');
            $table->string('product_stock');
            $table->string('uploaded_by')->default(0);
            $table->string('vendor_id');
            $table->string('product_status');
            $table->string('deleted_at')->nullable();
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
        Schema::dropIfExists('product');
    }
};
