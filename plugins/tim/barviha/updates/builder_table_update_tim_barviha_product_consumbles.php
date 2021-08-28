<?php namespace Tim\Barviha\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateTimBarvihaProductConsumbles extends Migration
{
    public function up()
    {
        Schema::table('tim_barviha_product_consumbles', function($table)
        {
            $table->smallInteger('value')->nullable(false)->unsigned(false)->default(null)->change();
        });
    }
    
    public function down()
    {
        Schema::table('tim_barviha_product_consumbles', function($table)
        {
            $table->integer('value')->nullable(false)->unsigned(false)->default(null)->change();
        });
    }
}
