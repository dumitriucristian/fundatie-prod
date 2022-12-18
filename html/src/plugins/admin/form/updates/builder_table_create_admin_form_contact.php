<?php namespace Admin\Form\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateAdminFormContact extends Migration
{
    public function up()
    {
        Schema::create('admin_form_contact', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->string('email');
            $table->string('phone_number')->nullable();
            $table->string('subject');
            $table->string('name');
            $table->text('text');
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('admin_form_contact');
    }
}
