<?php namespace Admin\Form\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateAdminFormClient6 extends Migration
{
    public function up()
    {
        Schema::table('admin_form_client', function($table)
        {
            $table->integer('postal_code')->nullable(false)->unsigned(false)->default(null)->change();
        });
    }
    
    public function down()
    {
        Schema::table('admin_form_client', function($table)
        {
            $table->string('postal_code', 255)->nullable(false)->unsigned(false)->default(null)->change();
        });
    }
}
