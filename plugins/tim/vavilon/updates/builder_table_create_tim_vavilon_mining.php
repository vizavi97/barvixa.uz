<?php namespace Tim\Vavilon\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateTimVavilonMining extends Migration
{
    public function up()
    {
        Schema::create('tim_vavilon_mining', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->string('name');
            $table->integer('v_energy_count');
            $table->integer('base_invest_value');
            $table->integer('base_profit_value');
            $table->string('type');
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('tim_vavilon_mining');
    }
}
