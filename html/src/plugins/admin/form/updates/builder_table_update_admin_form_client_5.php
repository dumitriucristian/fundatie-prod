<?php namespace Admin\Form\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateAdminFormClient5 extends Migration
{
    public function up()
    {
        Schema::table('admin_form_client', function($table)
        {
            $table->string('postal_code');
        });
    }
    
    public function down()
    {
        Schema::table('admin_form_client', function($table)
        {
            $table->dropColumn('postal_code');
        });
    }
}
