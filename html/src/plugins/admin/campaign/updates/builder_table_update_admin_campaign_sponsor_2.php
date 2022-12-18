<?php namespace Admin\Campaign\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateAdminCampaignSponsor2 extends Migration
{
    public function up()
    {
        Schema::table('admin_campaign_sponsor', function($table)
        {
            $table->string('page_sponsor', 255)->nullable()->change();
        });
    }
    
    public function down()
    {
        Schema::table('admin_campaign_sponsor', function($table)
        {
            $table->string('page_sponsor', 255)->nullable(false)->change();
        });
    }
}
