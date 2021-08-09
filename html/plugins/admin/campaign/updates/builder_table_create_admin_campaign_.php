<?php namespace Admin\Campaign\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateAdminCampaign extends Migration
{
    public function up()
    {
        Schema::create('admin_campaign_', function($table)
        {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id');
            $table->string('name');
            $table->dateTime('expire_at');
            $table->integer('target_money');
            $table->enum('campaign_type',['ziua_esarfelor','adopta_o_mama','mesaje_de_iubire','incaltam_un_copil','invatatoare_anului'])->nullable();
            $table->string('slug')->nullable();
            $table->enum('year',[2000,2001,2002,2003,2004,2005,2006,2007,2008,2009,2010,2011,2012,2013,2014,2015,2016,2017,2018,2019,2020,2021,2022,2023,2024,2025,2026,2027,2028,2029,2030,2031,2032,2033,2034,2035,2036,2037,2038,2039,2040])->nullable();
            $table->integer('raised_money')->default(0);
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('admin_campaign_');
    }
}
