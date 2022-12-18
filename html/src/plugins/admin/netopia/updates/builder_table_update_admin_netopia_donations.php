<?php namespace Admin\Netopia\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateAdminNetopiaDonations extends Migration
{
    public function up()
    {
        Schema::table('admin_netopia_donations', function($table)
        {
            $table->string('status', 255)->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('admin_netopia_donations', function($table)
        {
            $table->dropColumn('status');
        });
    }
}
