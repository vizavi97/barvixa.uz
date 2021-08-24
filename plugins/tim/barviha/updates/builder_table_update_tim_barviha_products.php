<?php namespace Tim\Barviha\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateTimBarvihaProducts extends Migration
{
    public function up()
    {
        Schema::table('tim_barviha_products', function($table)
        {
            $table->string('slug');
        });
    }
    
    public function down()
    {
        Schema::table('tim_barviha_products', function($table)
        {
            $table->dropColumn('slug');
        });
    }
}
