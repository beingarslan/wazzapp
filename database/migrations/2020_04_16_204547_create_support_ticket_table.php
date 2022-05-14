<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSupportTicketTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('support_ticket', function (Blueprint $table) {
            $table->id('tkID');
            $table->bigInteger('userID')->unsigned()->index();
            $table->string('subject');
            $table->string('description');
            $table->date('dateOpened');
            $table->string('status');
            $table->string('reply')->default("Nan");
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
        Schema::dropIfExists('support_ticket');
    }
}
