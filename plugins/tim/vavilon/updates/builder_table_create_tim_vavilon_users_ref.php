<?php namespace Tim\Vavilon\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateTimVavilonUsersRef extends Migration
{
    public function up()
    {
        Schema::create('tim_vavilon_users_ref', function($table)
        {
            $table->engine = 'InnoDB';
            $table->integer('parent_id');
            $table->integer('ref_id');
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('tim_vavilon_users_ref');
    }
}
