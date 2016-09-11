$(document).ready(function() {
load_map(gpxUrl);
});

function load_map(gpx) {
    var map = new L.Map('map');

    var el = L.control.elevation();
    el.addTo(map);

    L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    var g = new L.GPX(gpx, {
        async: true,
        marker_options: {
            startIconUrl: '/images/pin-icon-start.png',
            endIconUrl: '/images/pin-icon-end.png',
            shadowUrl: '/images/pin-shadow.png'
        }
    });

    g.on('loaded', function(e) {
        map.fitBounds(e.target.getBounds());
    });

    g.on("addline",function(e){
        el.addData(e.line);
    });

    g.addTo(map);
}
