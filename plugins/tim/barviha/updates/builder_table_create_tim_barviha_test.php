<?php namespace Tim\Barviha\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateTimBarvihaTest extends Migration
{
    public function up()
    {
        Schema::create('tim_barviha_test', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->text('info');
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('tim_barviha_test');
    }
}
