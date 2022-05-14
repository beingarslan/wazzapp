<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Z extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::select("ALTER TABLE `fund_load_history` ADD FOREIGN KEY (`userID`) REFERENCES `users`(`userID`) ON DELETE NO ACTION ON UPDATE NO ACTION;") ;
        DB::select("ALTER TABLE `fund_load_history` ADD FOREIGN KEY (`planID`) REFERENCES `plan`(`planID`) ON DELETE NO ACTION ON UPDATE NO ACTION;") ;
        DB::select("ALTER TABLE `users` ADD FOREIGN KEY (`planID`) REFERENCES `plan`(`planID`) ON DELETE NO ACTION ON UPDATE NO ACTION;") ;
        DB::select("ALTER TABLE `support_ticket` ADD FOREIGN KEY (`userID`) REFERENCES `users`(`userID`) ON DELETE NO ACTION ON UPDATE NO ACTION;") ;
        DB::select("ALTER TABLE `links` ADD FOREIGN KEY (`userID`) REFERENCES `users`(`userID`) ON DELETE NO ACTION ON UPDATE NO ACTION;") ;
        DB::select("ALTER TABLE `links` ADD FOREIGN KEY (`teamID`) REFERENCES `team`(`teamID`) ON DELETE NO ACTION ON UPDATE NO ACTION;") ;
        DB::select("ALTER TABLE `team_Member` ADD FOREIGN KEY (`teamID`) REFERENCES `team`(`teamID`) ON DELETE NO ACTION ON UPDATE NO ACTION;") ;
       
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
