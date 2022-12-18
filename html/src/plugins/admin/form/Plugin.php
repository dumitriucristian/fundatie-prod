<?php namespace Admin\Form;

use System\Classes\PluginBase;

class Plugin extends PluginBase
{
    public function registerComponents()
    {
        return [
            'Admin\Form\Components\clientform' => 'form',
            'Admin\Form\Components\newsletterform' => 'newsletter',
            'Admin\Form\Components\contactform' => 'contact',
            'Admin\Form\Components\clientformdownload' => 'clientformdownload',
        ];
    }

    public function registerSettings()
    {
    }
}
