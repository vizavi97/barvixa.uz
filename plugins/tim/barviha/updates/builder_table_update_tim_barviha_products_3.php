<?php namespace Tim\Barviha\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateTimBarvihaProducts3 extends Migration
{
    public function up()
    {
        Schema::table('tim_barviha_products', function($table)
        {
            $table->renameColumn('category', 'category_id');
        });
    }
    
    public function down()
    {
        Schema::table('tim_barviha_products', function($table)
        {
            $table->renameColumn('category_id', 'category');
        });
    }
}
