<?php namespace Tim\Barviha\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateTimBarvihaProductCategories2 extends Migration
{
    public function up()
    {
        Schema::table('tim_barviha_product_categories', function($table)
        {
            $table->string('type');
        });
    }
    
    public function down()
    {
        Schema::table('tim_barviha_product_categories', function($table)
        {
            $table->dropColumn('type');
        });
    }
}
