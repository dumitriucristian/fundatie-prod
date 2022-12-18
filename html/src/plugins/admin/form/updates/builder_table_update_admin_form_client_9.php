<?php namespace Admin\Form\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateAdminFormClient9 extends Migration
{
    public function up()
    {
        Schema::table('admin_form_client', function($table)
        {
            $table->integer('postal_code')->nullable()->change();
        });
    }
    
    public function down()
    {
        Schema::table('admin_form_client', function($table)
        {
            $table->integer('postal_code')->nullable(false)->change();
        });
    }
}
