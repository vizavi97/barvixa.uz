<?php namespace Tim\Vavilon\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateTimVavilonStacking extends Migration
{
    public function up()
    {
        Schema::create('tim_vavilon_stacking', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->string('profit');
            $table->integer('profit_min_percent');
            $table->integer('profit_max_percent');
            $table->string('type');
            $table->integer('min_attachment');
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('tim_vavilon_stacking');
    }
}
