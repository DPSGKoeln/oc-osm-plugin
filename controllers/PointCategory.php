<?php namespace Zoomyboy\Osm\Controllers;

use BackendMenu;
use Backend\Classes\Controller;

/**
 * Point Category Back-end Controller
 */
class PointCategory extends Controller
{
    public $implement = [
        'Backend.Behaviors.FormController',
        'Backend.Behaviors.ListController'
    ];

    public $formConfig = 'config_form.yaml';
    public $listConfig = 'config_list.yaml';

    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('Zoomyboy.Osm', 'osm', 'point_category');
    }
}
