<?php namespace Zoomyboy\Osm\Components;

use Cms\Classes\ComponentBase;
use System\Classes\MediaLibrary;
use RainLab\Pages\Interfaces\Gutenbergable;
use Zoomyboy\Osm\Models\Category;
use Zoomyboy\Osm\Models\Point;

class OsmMap extends ComponentBase implements Gutenbergable
{

    public $points;

    public function componentDetails()
    {
        return [
            'name'        => 'OsmMap',
            'description' => 'Displays a OSM Map',
            'icon' => 'map',
        ];
    }

    public function defineProperties()
    {
        return [
            'pointCategory' => [
                'label' => 'Punkt-Kategorie',
                'type' => 'dropdown'
            ],
            'height' => [
                'label' => 'Höhe'
            ]
        ];
    }

    public function onRun() {
        $this->addJs('/plugins/zoomyboy/osm/assets/public/osm.js');
        $this->addCss('/plugins/zoomyboy/osm/assets/public/osm.css');

        $this->points = Point::where('category_id', $this->property('pointCategory'))->get()->map(function($point) {
            $point->icon = MediaLibrary::url($point->icon);

            return $point;
        });
    }

    public function getPointCategoryOptions() {
        return Category::get()->pluck('name', 'id')->toArray();
    }
}
