<?php namespace Tim\Barviha\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateTimBarvihaRequestsTypes extends Migration
{
    public function up()
    {
        Schema::rename('tim_barviha_request_types', 'tim_barviha_requests_types');
    }
    
    public function down()
    {
        Schema::rename('tim_barviha_requests_types', 'tim_barviha_request_types');
    }
}
