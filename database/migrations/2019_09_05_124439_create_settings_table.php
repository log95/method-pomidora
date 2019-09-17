<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSettingsTable extends Migration
{
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->bigInteger('user_id')->primary()->nullable(false);
            $table->integer('pomidor_duration')->nullable(false);
            $table->integer('short_rest_duration')->nullable(false);
            $table->integer('long_rest_duration')->nullable(false);
            $table->integer('long_rest_via_count_pomidors')->nullable(false);
            $table->boolean('need_sound_timer_finished');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('settings');
    }
}
