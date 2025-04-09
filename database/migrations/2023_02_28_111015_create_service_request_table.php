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
        Schema::create('service_request', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->nullable();
            $table->integer('emp_id')->nullable();
            $table->integer('manger_id')->nullable();
            $table->integer('otp')->nullable();
            $table->integer('mob_verify')->nullable();
            $table->string('Service_request');
            $table->string('pictures')->nullable();
            $table->string('phone');
            $table->string('discription');
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->string('address')->nullable();
            $table->tinyInteger('status')->default(0)->comment('0:pending,1:assigned,2:inprocess,3:complated');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable()->useCurrentOnUpdate();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('service_request');
    }
};
