let leafletMapCreateElement = $('#leaflet-map-create');
let leafletMapViewElement = $('#leaflet-map-view');
let leafletMapListElement = $('#leaflet-map-list');


function createMap(element, center, zoom) {
    let config = {
        center: {
            lat: 45.4707,
            lng: 16.3586,
        },
        zoom: 7.5,
    }

    let tiles = L.tileLayer(element.data('tile-layer'), {
        minZoom: 8,
        maxZoom: 18,
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    });

    return L.map(element.attr('id'), {
        center: L.latLng(
            !center ? config.center.lat : center.lat,
            !center ? config.center.lng : center.lng
        ),
        zoom: !zoom ? config.zoom : zoom,
        layers: [tiles]
    });
}


if (leafletMapCreateElement.length) {
    let map = createMap(leafletMapCreateElement);
    let marker = null;

    map.on('click', function (e) {
        if (marker) {
            map.removeLayer(marker)
        }
        marker = new L.marker(e.latlng).addTo(map);
        $('#post_latitude').val(e.latlng.lat);
        $('#post_longitude').val(e.latlng.lng);
    });
} else if (leafletMapListElement.length) {
    let map = createMap(leafletMapListElement);
    let markers = L.markerClusterGroup();
    let mapPoints = leafletMapListElement.data('map-points');

    for (let i = 0; i < mapPoints.length; i++) {
        let mapPoint = mapPoints[i];
        let content = $('#leaflet-content-' + mapPoint.id).html();
        let marker = L.marker(
            new L.LatLng(mapPoint.latitude, mapPoint.longitude),
            {
                title: content
            }
        );

        marker.bindPopup(content);
        markers.addLayer(marker);
    }

    map.addLayer(markers);
} else if (leafletMapViewElement.length) {
    let mapPoint = leafletMapViewElement.data('map-point');
    let map = createMap(leafletMapViewElement, {
        lat: mapPoint.latitude,
        lng: mapPoint.longitude
    }, 9);

    let markers = L.markerClusterGroup();
    let marker = L.marker(
        new L.LatLng(mapPoint.latitude, mapPoint.longitude),
        {
            title: mapPoint.title
        }
    );

    marker.bindPopup(mapPoint.title);
    markers.addLayer(marker);

    map.addLayer(markers);
}
