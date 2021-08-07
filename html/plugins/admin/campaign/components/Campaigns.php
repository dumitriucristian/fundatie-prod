<?php namespace Admin\Campaign\Components;

use Cms\Classes\ComponentBase;
use Admin\Campaign\Models\Campaign;

class Campaigns extends ComponentBase
{
    public $campaigns;

    public function componentDetails()
    {
        return [
            'name' => 'Campaign List',
            'description' => 'A list of campaigns',
        ];
    }

    public function onRun()
    {
        $this->campaigns = $this->loadCampaigns();
    }

    protected function loadCampaigns()
    {
        return Campaign::all();
    }
    
}