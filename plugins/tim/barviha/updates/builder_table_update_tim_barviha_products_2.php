<?php namespace Tim\Barviha\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateTimBarvihaProducts2 extends Migration
{
    public function up()
    {
        Schema::table('tim_barviha_products', function($table)
        {
            $table->renameColumn('categories_id', 'category');
        });
    }
    
    public function down()
    {
        Schema::table('tim_barviha_products', function($table)
        {
            $table->renameColumn('category', 'categories_id');
        });
    }
}
