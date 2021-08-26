<?php namespace Tim\Barviha\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateTimBarvihaConsumables3 extends Migration
{
    public function up()
    {
        Schema::table('tim_barviha_consumables', function($table)
        {
            $table->string('group');
        });
    }
    
    public function down()
    {
        Schema::table('tim_barviha_consumables', function($table)
        {
            $table->dropColumn('group');
        });
    }
}
