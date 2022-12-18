<?php namespace Admin\Campaign\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateAdminCampaign4 extends Migration
{
    public function up()
    {
        Schema::table('admin_campaign_', function($table)
        {
            $table->integer('order')->default(1000);
        });
    }
    
    public function down()
    {
        Schema::table('admin_campaign_', function($table)
        {
            $table->dropColumn('order');
        });
    }
}
