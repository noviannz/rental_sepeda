<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMachineLogsTable extends Migration
{
    public function up()
    {
        Schema::create('machine_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bike_id')->constrained('bikes')->onDelete('cascade');
            $table->foreignId('station_id')->constrained('stations')->onDelete('cascade');
            $table->timestamp('log_time');
            $table->string('event');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('machine_logs');
    }
}
