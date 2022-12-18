<?php namespace Admin\Form\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateAdminFormClient7 extends Migration
{
    public function up()
    {
        Schema::table('admin_form_client', function($table)
        {
            $table->string('picture_form');
        });
    }
    
    public function down()
    {
        Schema::table('admin_form_client', function($table)
        {
            $table->dropColumn('picture_form');
        });
    }
}
