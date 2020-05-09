import 'ol/ol.css';
import { Map, View } from 'ol';
import TileLayer from 'ol/layer/Tile';
import OSM from 'ol/source/OSM';
import { fromLonLat } from 'ol/proj';
import Overlay from 'ol/Overlay';
import VectorLayer from 'ol/layer/Vector';
import VectorSource from 'ol/source/Vector';
import Feature from 'ol/Feature';
import Point from 'ol/geom/Point';
import Style from 'ol/style/Style';
import Icon from 'ol/style/Icon';
import * as olSize from 'ol/size';
import * as olExtent from 'ol/extent';
import Select from 'ol/interaction/Select';
import { click } from 'ol/events/condition';


function getCenter(points) {
    return [
        points.reduce((pv, c) => pv + parseFloat(c.location.lon), 0) / points.length,
        points.reduce((pv, c) => pv + parseFloat(c.location.lat), 0) / points.length,
    ];
}

$(document).ready(function() {
    $('[data-osm]').each(function() {
        var points = JSON.parse(this.dataset.points);

        var view = new View({
            center: fromLonLat(getCenter(points)),
            zoom: 8
        });

        const map = new Map({
            target: this,
            view: view
        });

        map.addLayer(new TileLayer({
            source: new OSM()
        }));

        var extent = olExtent.createEmpty();

        var features = points.map((point) => {
            var location = new Point(fromLonLat([point.location.lon, point.location.lat]));
            var feature = new Feature({
                geometry: location,
                id: point.id
            });
            feature.setStyle(new Style({
                image: new Icon({
                    src: point.icon,
                    scale: 0.03,
                    color: '#ff0000',
                })
            }));

            olExtent.extend(extent, location.getExtent());

            return feature;
        });

        var layer = new VectorLayer({
            source: new VectorSource({
                features: features
            })
        });

        map.addLayer(layer);

        map.on('click', function(e) {
            map.forEachFeatureAtPixel(e.pixel, (feature) => {
                console.log(feature.get('id'));
            });
        });


        extent = olExtent.buffer(extent, 2000);

        map.getView().fit(extent);
    });
});

