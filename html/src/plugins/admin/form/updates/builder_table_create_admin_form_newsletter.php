<?php namespace Admin\Form\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateAdminFormNewsletter extends Migration
{
    public function up()
    {
        Schema::create('admin_form_newsletter', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->string('email');
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('admin_form_newsletter');
    }
}
