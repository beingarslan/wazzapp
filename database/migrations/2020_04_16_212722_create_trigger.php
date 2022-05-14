<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrigger extends Migration {

    public function up()
    {
        DB::unprepared("CREATE TRIGGER trSubscription AFTER INSERT ON fund_load_history FOR EACH ROW BEGIN UPDATE users SET planID = new.planID WHERE new.userid = users.userid; END;");
   }

    public function down()
    {
        DB::unprepared('DROP TRIGGER `trSubscription`');
        
    }
}
