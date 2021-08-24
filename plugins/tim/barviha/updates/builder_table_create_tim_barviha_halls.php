<?php namespace Tim\Barviha\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateTimBarvihaHalls extends Migration
{
    public function up()
    {
        Schema::create('tim_barviha_halls', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->string('title');
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('tim_barviha_halls');
    }
}
