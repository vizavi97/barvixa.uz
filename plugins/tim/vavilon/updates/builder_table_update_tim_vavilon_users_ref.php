<?php namespace Tim\Vavilon\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateTimVavilonUsersRef extends Migration
{
    public function up()
    {
        Schema::table('tim_vavilon_users_ref', function($table)
        {
            $table->renameColumn('parent_id', 'user_id');
        });
    }
    
    public function down()
    {
        Schema::table('tim_vavilon_users_ref', function($table)
        {
            $table->renameColumn('user_id', 'parent_id');
        });
    }
}
