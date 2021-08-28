<?php namespace Tim\Barviha\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateTimBarvihaRequestProducts extends Migration
{
    public function up()
    {
        Schema::create('tim_barviha_request_products', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->integer('request_id');
            $table->integer('product_id');
            $table->integer('count');
            $table->integer('count_value');
            $table->integer('total_value');
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('tim_barviha_request_products');
    }
}
