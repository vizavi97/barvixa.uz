<?php namespace Tim\Vavilon\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateTimVavilonMining2 extends Migration
{
    public function up()
    {
        Schema::table('tim_vavilon_mining', function($table)
        {
            $table->boolean('is_active');
        });
    }
    
    public function down()
    {
        Schema::table('tim_vavilon_mining', function($table)
        {
            $table->dropColumn('is_active');
        });
    }
}
