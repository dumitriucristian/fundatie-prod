<?php namespace Admin\Campaign\Components;

use Cms\Classes\ComponentBase;
use Request;
use Admin\Campaign\Traits\SingleCampaignTrait;
use Log;

class CampaignCarousel extends ComponentBase
{
    use SingleCampaignTrait;

    public $campaign;

    public function componentDetails()
    {
        return [
            'name' => 'Campaign carousel display',
            'description' => 'Campaign carousel display',
        ];
    }
    
    public function onRun()
    {
        $this->campaign = $this->loadCampaign($this->property('year'),$this->property('slug'));
        if(!$this->campaign)
        {
            Log::error("Campania din url a fost scrisa gresit");
            return redirect('404');  
        }
    }
    
}