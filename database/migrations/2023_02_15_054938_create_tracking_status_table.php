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
        Schema::create('tracking_status', function (Blueprint $table) {
            $table->increments('id');
            $table->string('Service_request_id')->nullable();
            $table->string('service_generated')->nullable();
            $table->string('Pending_assignment')->nullable();
            $table->string('assign_engineer')->nullable();
            $table->string('engineer_checkin')->nullable();
            $table->string('service_process')->nullable();
            $table->string('solve_by_engineer')->nullable();
            $table->string('service_closed')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
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
        Schema::dropIfExists('tracking_status');
    }
};
