<?php namespace Tim\Barviha\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateTimBarvihaProducts5 extends Migration
{
    public function up()
    {
        Schema::table('tim_barviha_products', function($table)
        {
            $table->increments('id')->unsigned();
        });
    }
    
    public function down()
    {
        Schema::table('tim_barviha_products', function($table)
        {
            $table->dropColumn('id');
        });
    }
}
