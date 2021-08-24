<?php namespace Tim\Vavilon\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateTimVavilonStacking3 extends Migration
{
    public function up()
    {
        Schema::table('tim_vavilon_stacking', function($table)
        {
            $table->string('name');
        });
    }
    
    public function down()
    {
        Schema::table('tim_vavilon_stacking', function($table)
        {
            $table->dropColumn('name');
        });
    }
}
