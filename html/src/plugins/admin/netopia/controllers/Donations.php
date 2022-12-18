<?php namespace Admin\Netopia\Controllers;

use Backend\Classes\Controller;
use BackendMenu;

class Donations extends Controller
{
    public $implement = [        'Backend\Behaviors\ListController',        'Backend\Behaviors\FormController'    ];
    
    public $listConfig = 'config_list.yaml';
    public $formConfig = 'config_form.yaml';

    public function __construct()
    {
        parent::__construct();
        BackendMenu::setContext('Admin.Netopia', 'main-menu-item');
    }
}
