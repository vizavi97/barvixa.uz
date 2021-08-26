<?php namespace Tim\Barviha\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateTimBarvihaConsumables2 extends Migration
{
    public function up()
    {
        Schema::table('tim_barviha_consumables', function($table)
        {
            $table->integer('price');
        });
    }
    
    public function down()
    {
        Schema::table('tim_barviha_consumables', function($table)
        {
            $table->dropColumn('price');
        });
    }
}
