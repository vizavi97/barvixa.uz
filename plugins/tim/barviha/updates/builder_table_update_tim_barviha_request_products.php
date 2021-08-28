<?php namespace Tim\Barviha\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateTimBarvihaRequestProducts extends Migration
{
    public function up()
    {
        Schema::table('tim_barviha_request_products', function($table)
        {
            $table->dropColumn('count_value');
        });
    }
    
    public function down()
    {
        Schema::table('tim_barviha_request_products', function($table)
        {
            $table->integer('count_value');
        });
    }
}
