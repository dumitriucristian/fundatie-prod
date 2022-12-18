<?php namespace Admin\Form\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateAdminFormClient3 extends Migration
{
    public function up()
    {
        Schema::table('admin_form_client', function($table)
        {
            $table->string('floor', 255)->nullable()->unsigned(false)->default(null)->change();
        });
    }
    
    public function down()
    {
        Schema::table('admin_form_client', function($table)
        {
            $table->integer('floor')->nullable()->unsigned(false)->default(null)->change();
        });
    }
}
