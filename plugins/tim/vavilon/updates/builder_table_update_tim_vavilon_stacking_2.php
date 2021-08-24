<?php namespace Tim\Vavilon\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateTimVavilonStacking2 extends Migration
{
    public function up()
    {
        Schema::table('tim_vavilon_stacking', function($table)
        {
            $table->boolean('is_active')->default(0);
        });
    }
    
    public function down()
    {
        Schema::table('tim_vavilon_stacking', function($table)
        {
            $table->dropColumn('is_active');
        });
    }
}
