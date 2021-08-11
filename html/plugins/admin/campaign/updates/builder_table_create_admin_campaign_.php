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
            $table->enum('year',range(2000,2040))->nullable();
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
