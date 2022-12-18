<?php namespace Admin\Campaign\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateAdminCampaignSponsor3 extends Migration
{
    public function up()
    {
        Schema::table('admin_campaign_sponsor', function($table)
        {
            $table->text('description')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('admin_campaign_sponsor', function($table)
        {
            $table->dropColumn('description');
        });
    }
}
