<?php namespace Tim\Barviha\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateTimBarvihaRequests4 extends Migration
{
    public function up()
    {
        Schema::table('tim_barviha_requests', function($table)
        {
            $table->renameColumn('price', 'amount');
        });
    }
    
    public function down()
    {
        Schema::table('tim_barviha_requests', function($table)
        {
            $table->renameColumn('amount', 'price');
        });
    }
}
