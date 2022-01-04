<?php namespace Zoomyboy\Osm;

use Backend;
use GuzzleHttp\Client;
use System\Classes\PluginBase;
use Zoomyboy\Osm\Classes\Nominatim;
use Zoomyboy\Osm\FormWidgets\Location;

/**
 * osm Plugin Information File
 */
class Plugin extends PluginBase
{
    /**
     * Returns information about this plugin.
     *
     * @return array
     */
    public function pluginDetails()
    {
        return [
            'name'        => 'osm',
            'description' => 'Plugin for OpenStreetMap functions',
            'author'      => 'zoomyboy',
            'icon'        => 'icon-leaf'
        ];
    }

    /**
     * Register method, called when the plugin is first registered.
     *
     * @return void
     */
    public function register()
    {
        app()->bind(Nominatim::class, function() {
            $client = new Client(['base_uri' => 'https://nominatim.openstreetmap.org']);
            return new Nominatim($client);
        });
    }

    /**
     * Boot method, called right before the request route.
     *
     * @return array
     */
    public function boot()
    {

    }

    /**
     * Registers any front-end components implemented in this plugin.
     *
     * @return array
     */
    public function registerComponents()
    {
        return [];
    }

    /**
     * Registers any back-end permissions used by this plugin.
     *
     * @return array
     */
    public function registerPermissions()
    {
        return [];
    }

    public function registerFormWidgets() {
        return [
            Location::class => 'zoomyboy_osm_location'
        ];
    }

    /**
     * Registers back-end navigation items for this plugin.
     *
     * @return array
     */
    public function registerNavigation()
    {
        return [];
    }
}
