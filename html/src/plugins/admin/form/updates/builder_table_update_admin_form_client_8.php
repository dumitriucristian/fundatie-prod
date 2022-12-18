<?php namespace Admin\Form\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateAdminFormClient8 extends Migration
{
    public function up()
    {
        Schema::table('admin_form_client', function($table)
        {
            $table->renameColumn('picture_form', 'uuid');
        });
    }
    
    public function down()
    {
        Schema::table('admin_form_client', function($table)
        {
            $table->renameColumn('uuid', 'picture_form');
        });
    }
}
