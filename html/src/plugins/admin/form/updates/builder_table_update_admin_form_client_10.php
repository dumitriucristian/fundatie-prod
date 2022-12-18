<?php namespace Admin\Form\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateAdminFormClient10 extends Migration
{
    public function up()
    {
        Schema::table('admin_form_client', function($table)
        {
            $table->boolean('newsletter')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('admin_form_client', function($table)
        {
            $table->dropColumn('newsletter');
        });
    }
}
