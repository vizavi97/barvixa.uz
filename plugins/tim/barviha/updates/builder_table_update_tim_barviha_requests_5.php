<?php namespace Tim\Barviha\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateTimBarvihaRequests5 extends Migration
{
    public function up()
    {
        Schema::table('tim_barviha_requests', function($table)
        {
            $table->dropColumn('products');
        });
    }
    
    public function down()
    {
        Schema::table('tim_barviha_requests', function($table)
        {
            $table->text('products');
        });
    }
}
