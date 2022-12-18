<?php namespace Admin\Campaign\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateAdminCampaignSponsor extends Migration
{
    public function up()
    {
        Schema::table('admin_campaign_sponsor', function($table)
        {
            $table->string('page_sponsor');
        });
    }
    
    public function down()
    {
        Schema::table('admin_campaign_sponsor', function($table)
        {
            $table->dropColumn('page_sponsor');
        });
    }
}
