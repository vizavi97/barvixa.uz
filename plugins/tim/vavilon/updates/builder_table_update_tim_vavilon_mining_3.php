<?php namespace Tim\Vavilon\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateTimVavilonMining3 extends Migration
{
    public function up()
    {
        Schema::table('tim_vavilon_mining', function($table)
        {
            $table->boolean('is_active')->default(1)->change();
        });
    }
    
    public function down()
    {
        Schema::table('tim_vavilon_mining', function($table)
        {
            $table->boolean('is_active')->default(null)->change();
        });
    }
}
