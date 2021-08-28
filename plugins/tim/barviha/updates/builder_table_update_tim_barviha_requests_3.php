<?php namespace Tim\Barviha\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateTimBarvihaRequests3 extends Migration
{
    public function up()
    {
        Schema::table('tim_barviha_requests', function($table)
        {
            $table->integer('hall_id');
            $table->integer('place_id');
            $table->integer('cashier_id');
        });
    }
    
    public function down()
    {
        Schema::table('tim_barviha_requests', function($table)
        {
            $table->dropColumn('hall_id');
            $table->dropColumn('place_id');
            $table->dropColumn('cashier_id');
        });
    }
}
