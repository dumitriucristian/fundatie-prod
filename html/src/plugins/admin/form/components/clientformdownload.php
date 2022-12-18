<?php namespace Admin\Form\Components;

use Cms\Classes\ComponentBase;
use Admin\Form\Models\Client;
use Log;

class ClientFormDownload extends ComponentBase 
{
    public $client;

    
    public function componentDetails()
    {
        return [
            'name' => 'Download form',
            'description' => 'Download form client',
        ];
    }
    
    public function defineProperties()
    {
        return [
            'uuid' => [
                'title' => 'form uuid',
                'required' => true,
            ],
        ];
    }

    public function onRun()
    {
        $this->client = Client::where('uuid', $this->property('uuid'))->first();
        if (!$this->client) {
            Log::error("Uuid pentru formular din url a fost scrisa gresit");
            return redirect('404');
        }
    }
}