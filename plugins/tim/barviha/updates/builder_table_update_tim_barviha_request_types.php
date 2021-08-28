<?php namespace Tim\Barviha\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateTimBarvihaRequestTypes extends Migration
{
    public function up()
    {
        Schema::table('tim_barviha_request_types', function($table)
        {
            $table->dropColumn('deleted_at');
        });
    }
    
    public function down()
    {
        Schema::table('tim_barviha_request_types', function($table)
        {
            $table->timestamp('deleted_at')->nullable();
        });
    }
}
