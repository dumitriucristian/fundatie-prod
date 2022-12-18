<?php namespace Admin\Campaign\Components;

use Cms\Classes\ComponentBase;
use Admin\Campaign\Models\Campaign;
use Admin\Campaign\Models\CampaignType;

class Campaigns extends ComponentBase
{
    public $campaigns;

    public function defineProperties()
    {
        return [
            'type' => [
                'title' => 'Campaign type',
                'required' => true,
            ]
        ];
    }

    public function componentDetails()
    {
        return [
            'name' => 'Campaign List',
            'description' => 'A list of campaigns',
        ];
    }

    public function onRun()
    {
        $campaignTypeId = CampaignType::where('slug',$this->property('type'))->first()->id; 
        $this->campaigns = Campaign::where('campaign_type_id',$campaignTypeId)->orderBy('order','asc')->get();
    }
    
}