<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccesshistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accesshistory', function (Blueprint $table) {
            $table->id("accessID");
            $table->bigInteger("linkID")->unsigned()->index();
            $table->bigInteger("userID")->unsigned()->index();
            $table->text("Name");
            $table->text("Phone"); 
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
        Schema::dropIfExists('accesshistory');
    }
}
