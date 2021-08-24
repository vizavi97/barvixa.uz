<?php namespace Tim\Vavilon\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateTimVavilonMining5 extends Migration
{
    public function up()
    {
        Schema::table('tim_vavilon_mining', function($table)
        {
            $table->integer('daily_cost')->default(1)->change();
        });
    }
    
    public function down()
    {
        Schema::table('tim_vavilon_mining', function($table)
        {
            $table->integer('daily_cost')->default(null)->change();
        });
    }
}
