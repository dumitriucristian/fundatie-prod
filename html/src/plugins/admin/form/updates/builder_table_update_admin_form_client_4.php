<?php namespace Admin\Form\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateAdminFormClient4 extends Migration
{
    public function up()
    {
        Schema::table('admin_form_client', function($table)
        {
            $table->dropColumn('cnp');
        });
    }
    
    public function down()
    {
        Schema::table('admin_form_client', function($table)
        {
            $table->bigInteger('cnp');
        });
    }
}
