<?php namespace Admin\Netopia\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateAdminNetopiaDonations extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('admin_netopia_donations')) {
            Schema::create('admin_netopia_donations', function($table)
            {
                $table->engine = 'InnoDB';
                $table->increments('id');
                $table->integer('sum');
                $table->string('name');
                $table->string('surname');
                $table->string('phone');
                $table->string('message');
                $table->string('email');
                $table->string('payment_id')->nullable();
                $table->timestamp('created_at');
                $table->timestamp('updated_at')->nullable();
            });
        } 
    }
    
    public function down()
    {
        Schema::dropIfExists('admin_netopia_donations');
    }
}
