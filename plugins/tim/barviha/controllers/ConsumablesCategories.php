<?php namespace Tim\Barviha\Controllers;

use Backend\Classes\Controller;
use BackendMenu;

class ConsumablesCategories extends Controller
{
    public $implement = [        'Backend\Behaviors\ListController',        'Backend\Behaviors\FormController'    ];
    
    public $listConfig = 'config_list.yaml';
    public $formConfig = 'config_form.yaml';

    public function __construct()
    {
        parent::__construct();
        BackendMenu::setContext('Tim.Barviha', 'main-menu-item', 'side-menu-item7');
    }
}
