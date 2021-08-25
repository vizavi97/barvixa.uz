<?php namespace Tim\Barviha\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateTimBarvihaProducts4 extends Migration
{
    public function up()
    {
        Schema::table('tim_barviha_products', function($table)
        {
            $table->dropColumn('id');
        });
    }
    
    public function down()
    {
        Schema::table('tim_barviha_products', function($table)
        {
            $table->integer('id');
        });
    }
}
