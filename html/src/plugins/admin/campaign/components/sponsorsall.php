<?php namespace Admin\Campaign\Components;

use Cms\Classes\ComponentBase;
use Admin\Campaign\Models\Sponsor;

class SponsorsAll extends ComponentBase
{
    public $sponsors;

    public function componentDetails()
    {
        return [
            'name' => 'Display all sponsors',
            'description' => 'Display all sponsors',
        ];
    }
    
    public function onRun()
    {
        $this->sponsors = Sponsor::all();
    }
    
}