<?php namespace Tim\Barviha\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateTimBarvihaPlaces extends Migration
{
    public function up()
    {
        Schema::table('tim_barviha_places', function($table)
        {
            $table->smallInteger('hall_id');
            $table->dropColumn('hall');
        });
    }
    
    public function down()
    {
        Schema::table('tim_barviha_places', function($table)
        {
            $table->dropColumn('hall_id');
            $table->integer('hall');
        });
    }
}
