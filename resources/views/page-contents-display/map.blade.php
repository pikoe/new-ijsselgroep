<div id="map_{{ $map->id }}"></div>

@section('javascript')
@parent
<script type="text/javascript">
var mapDiv{{ $map->id }} = document.id('map_{{ $map->id }}').setStyle('height', 300);
var map{{ $map->id }};
function initMap{{ $map->id }}() {
	var pointLatLng = new google.maps.LatLng({{ $map->lat }}, {{ $map->lng }});

	map{{ $map->id }} = new google.maps.Map(mapDiv{{ $map->id }}, {
		zoom: {{ $map->zoom }},
		center: pointLatLng
	});

	new google.maps.Marker({
		position: pointLatLng,
		map: map{{ $map->id }},
		title: 'Punt'
	});
	
	mapDiv{{ $map->id }}.setStyle('height', Math.max(300, mapDiv{{ $map->id }}.getParent('.page-block').getSize().y - 50));
	google.maps.event.trigger(map{{ $map->id }}, 'resize');
}
window.addEvent('resize:pause(50)', function() {
	mapDiv{{ $map->id }}.setStyle('height', 300);
	(function(){
		mapDiv{{ $map->id }}.setStyle('height', Math.max(300, mapDiv{{ $map->id }}.getParent('.page-block').getSize().y - 50));
		google.maps.event.trigger(map{{ $map->id }}, 'resize');
	}).delay(50);
});
</script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBBC09E7Kd_cgBRpLjGZM4WseHTWVvCKLo&callback=initMap{{ $map->id }}"></script>
@endsection