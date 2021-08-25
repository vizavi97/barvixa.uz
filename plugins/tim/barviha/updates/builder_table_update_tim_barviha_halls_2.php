<?php namespace Tim\Barviha\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateTimBarvihaHalls2 extends Migration
{
    public function up()
    {
        Schema::table('tim_barviha_halls', function($table)
        {
            $table->increments('id')->unsigned(false)->change();
        });
    }
    
    public function down()
    {
        Schema::table('tim_barviha_halls', function($table)
        {
            $table->increments('id')->unsigned()->change();
        });
    }
}
