<?php namespace Admin\Campaign\Components;

use Cms\Classes\ComponentBase;
use October\Rain\Exception\ApplicationException;
use Admin\Campaign\Models\Campaign;

class SingleCampaign extends ComponentBase
{
    public $campaign;

    public function componentDetails()
    {
        return [
            'name' => 'A single campaign display',
            'description' => 'A single campaign display',
        ];
    }

    public function onRun()
    {
        if(!$this->param('slug'))
            throw new ApplicationException('Un slug de campanie nu se alfa in url!');

        $this->campaign = $this->loadCampaign($this->param('slug'));
    }

    protected function loadCampaign($slug)
    {
        return Campaign::where('slug',$slug)->first();
    }
    
}