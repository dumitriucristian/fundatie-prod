<?php namespace Admin\Netopia;

use System\Classes\PluginBase;

class Plugin extends PluginBase
{
    public function registerComponents()
    {
        return [
            'Admin\Netopia\Components\Card' => 'card',
            'Admin\Netopia\Components\Confirm' => 'confirm'
        ];
    }

    public function registerSettings()
    {
    }
}
