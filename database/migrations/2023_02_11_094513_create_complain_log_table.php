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
        Schema::create('complain_log', function (Blueprint $table) {
            $table->increments('id');
            $table->string('raise_complain_id')->nullable();
            $table->tinyInteger('ticket_generated')->default(0)->comment('0:pending,1:accept,2:complate');
            $table->tinyInteger('assign_manager')->default(0)->comment('0:pending,1:accept,2:complate');
            $table->tinyInteger('ticket_engineer')->default(0)->comment('0:pending,1:accept,2:complate');
            $table->tinyInteger('ticket_engineer_checkin')->default(0)->comment('0:pending,1:accept,2:complate');
            $table->tinyInteger('ticket_engineer_reviewing')->default(0)->comment('0:pending,1:accept,2:complate');
            $table->tinyInteger('ticket_engineer_complated')->default(0)->comment('0:pending,1:accept,2:complate');
            $table->tinyInteger('verify_by_manager')->default(0)->comment('0:pending,1:accept,2:complate');
            $table->softDeletes();
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
        Schema::dropIfExists('complain_log');
    }
};
