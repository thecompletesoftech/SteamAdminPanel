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
        Schema::create('sub_category_data', function (Blueprint $table) {
            $table->id();
            $table->integer('sub_services_id') ; // create user_id column;
            
             $table->string('sub_service_data');
              $table->string('link_with_product')->default(0);
              $table->string('product_category')->nullable();
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
        Schema::dropIfExists('sub_category_data');
    }
};
