<?php namespace Zoomyboy\Osm\FormWidgets;

use Backend\Classes\FormWidgetBase;

/**
 * OsmLocation Form Widget
 */
class Location extends FormWidgetBase
{
    /**
     * @inheritDoc
     */
    protected $defaultAlias = 'zoomyboy_osm_location';

    /**
     * @inheritDoc
     */
    public function init()
    {
    }

    /**
     * @inheritDoc
     */
    public function render()
    {
        $this->prepareVars();
        return $this->makePartial('location');
    }

    /**
     * Prepares the form widget view data
     */
    public function prepareVars()
    {
        $this->vars['name'] = $this->formField->getName();
        $this->vars['value'] = $this->getLoadValue();
        $this->vars['model'] = $this->model;
    }

    /**
     * @inheritDoc
     */
    public function loadAssets()
    {
        $this->addCss('css/location.css', 'zoomyboy.osm');
        $this->addJs('js/location.js', 'zoomyboy.osm');
    }

    /**
     * @inheritDoc
     */
    public function getSaveValue($value)
    {
        return $value;
    }
}
