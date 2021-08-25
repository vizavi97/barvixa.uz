<?php namespace Tim\Barviha\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateTimBarvihaConsumables extends Migration
{
    public function up()
    {
        Schema::table('tim_barviha_consumables', function($table)
        {
            $table->integer('value');
        });
    }
    
    public function down()
    {
        Schema::table('tim_barviha_consumables', function($table)
        {
            $table->dropColumn('value');
        });
    }
}
