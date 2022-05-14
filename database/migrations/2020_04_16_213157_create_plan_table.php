<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plan', function (Blueprint $table) {
            $table->id('planID');
            $table->string('PlanTitle');
            $table->double('OriginalPrice');
            $table->double('SalesPrice');
            $table->string('PlanDescription');
            $table->integer('linksAllowed')->default(0);
            $table->integer('teamsAllowed')->default(0);
            $table->integer('clicksAllowed')->default(0);
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
        Schema::dropIfExists('plan');
    }
}
