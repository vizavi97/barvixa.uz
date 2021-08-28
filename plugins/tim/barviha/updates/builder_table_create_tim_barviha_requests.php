<?php namespace Tim\Barviha\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateTimBarvihaRequests extends Migration
{
    public function up()
    {
        Schema::create('tim_barviha_requests', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->integer('price');
            $table->text('products');
            $table->integer('status_id');
            $table->integer('waiter_id');
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->dateTime('closed_at');
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('tim_barviha_requests');
    }
}
