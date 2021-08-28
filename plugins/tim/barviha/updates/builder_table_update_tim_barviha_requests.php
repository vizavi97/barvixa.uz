<?php namespace Tim\Barviha\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateTimBarvihaRequests extends Migration
{
    public function up()
    {
        Schema::table('tim_barviha_requests', function($table)
        {
            $table->smallInteger('closed_at')->nullable(false)->unsigned(false)->default(null)->change();
        });
    }
    
    public function down()
    {
        Schema::table('tim_barviha_requests', function($table)
        {
            $table->dateTime('closed_at')->nullable(false)->unsigned(false)->default(null)->change();
        });
    }
}
