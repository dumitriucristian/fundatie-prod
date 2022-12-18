<?php namespace Admin\Campaign\Components;

use Cms\Classes\ComponentBase;
use Admin\Campaign\Models\CampaignType;

class CampaignTypeList extends ComponentBase
{
    public $campaignType;

    public function componentDetails()
    {
        return [
            'name' => 'Display all campaigns types',
            'description' => 'Display all campaigns types',
        ];
    }
    
    public function onRun()
    {
        $this->campaignType = CampaignType::orderBy('order','asc')->get();
    }
    
}