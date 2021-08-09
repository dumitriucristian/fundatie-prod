<?php namespace Admin\Campaign\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateAdminCampaign extends Migration
{
    public function up()
    {
        Schema::table('admin_campaign_', function($table)
        {
            $table->string('slug')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('admin_campaign_', function($table)
        {
            $table->dropColumn('slug');
        });
    }
}
