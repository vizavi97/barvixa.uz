<?php namespace Tim\Barviha\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateTimBarvihaProductCategories extends Migration
{
    public function up()
    {
        Schema::create('tim_barviha_product_categories', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->string('title');
            $table->string('slug');
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('tim_barviha_product_categories');
    }
}
