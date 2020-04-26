<?php namespace Zoomyboy\Osm\Controllers;

use BackendMenu;
use Backend\Classes\Controller;

/**
 * Index Back-end Controller
 */
class Index extends Controller
{
    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('Zoomyboy.Osm', 'osm', 'index');
    }

    public function index() {

    }
}
