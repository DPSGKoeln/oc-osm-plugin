<?php

namespace Zoomyboy\Osm\Classes;

use GuzzleHttp\Client;

class Nominatim {

    public $client;
    
    public function __construct(Client $client) {
        $this->client = $client;
    }

    public function resolve($location) {
        if (is_array($location)) {
            $location = implode(',', $location);
        }
        $response = $this->client->get('/search/', [
            'query' => ['q' => $location, 'format' => 'json', 'addressdetails' => '1']
        ]);

        return collect(json_decode((string) $response->getBody()))->map(function($location) {
            return (object) [
                'name' => $location->display_name,
                'lat' => $location->lat,
                'lon' => $location->lon,
                'nr' => $location->address->house_number ?? '',
                'address' => $location->address->road ?? '',
                'location' => $location->address->city ?? '',
                'zip' => $location->address->postcode ?? '',
                'country' => $location->address->country ?? '',
                'country_code' => $location->address->country_code ?? '',
            ];
        });
    }

}
