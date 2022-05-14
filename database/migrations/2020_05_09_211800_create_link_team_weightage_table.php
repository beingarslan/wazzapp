<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLinkTeamWeightageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('link_team_weightage', function (Blueprint $table) {
            $table->bigInteger("linkID")->unsigned()->index();
            $table->string("memberPhone");
            $table->text("clickPercentage");
            $table->text("AllowedClicks"); 
            $table->text("Status");
            $table->timestamps();
            $table->foreign("linkID")->references("linkID")->on("links");
        });
    }

    /*
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('link_team_weightage');
    }
}
