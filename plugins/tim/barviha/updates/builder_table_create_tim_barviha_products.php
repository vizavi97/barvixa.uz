<?php namespace Tim\Barviha\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateTimBarvihaProducts extends Migration
{
    public function up()
    {
        Schema::create('tim_barviha_products', function($table)
        {
            $table->engine = 'InnoDB';
            $table->integer('id');
            $table->string('title');
            $table->integer('cost');
            $table->text('desc')->nullable();
            $table->integer('categories_id');
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('tim_barviha_products');
    }
}
