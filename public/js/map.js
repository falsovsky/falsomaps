
$( document ).ready(function() {
	load_map(gpxUrl);
});

function load_map(gpx) {
	var map = new L.Map('map');

	var url = 'http://otile{s}.mqcdn.com/tiles/1.0.0/map/{z}/{x}/{y}.jpeg',
		attr = 'Tiles Courtesy of <a href="http://www.mapquest.com/">MapQuest</a> &mdash; Map data &copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors, <a href="http://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>',
		service = new L.TileLayer(url, {subdomains:"1234",attribution: attr});

	var el = L.control.elevation();
	el.addTo(map);

	map.addLayer(service);

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