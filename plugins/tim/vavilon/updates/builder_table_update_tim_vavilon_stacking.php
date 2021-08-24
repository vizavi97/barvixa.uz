<?php namespace Tim\Vavilon\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateTimVavilonStacking extends Migration
{
    public function up()
    {
        Schema::table('tim_vavilon_stacking', function($table)
        {
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('tim_vavilon_stacking', function($table)
        {
            $table->dropColumn('created_at');
            $table->dropColumn('updated_at');
        });
    }
}
