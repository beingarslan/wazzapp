<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBroadcastTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('broadcast', function (Blueprint $table) {
            $table->id('brid');
            $table->string('title');
            $table->string('message');
            $table->string('status');
            $table->date('startTime');
            $table->date('endTime');
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
        Schema::dropIfExists('broadcast');
    }
}
