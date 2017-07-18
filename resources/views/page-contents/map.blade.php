@extends('layouts.admin')

@section('crumbs')
<a href="{{ route('pages.index') }}">Pagina's</a>
<a href="{{ route('pages.edit', [$pageContent->page_id]) }}">{{ $pageContent->page->name }}</a>
<a href="{{ route('pagecontents.edit', [$pageContent->id]) }}">Kaart</a>
@endsection

@section('content')
<form class="form" id="image-form" action="{{ route('pagecontents.edit', [$pageContent->id]) }}" method="POST">
	<div class="toolbar clearfix">
		<input type="hidden" name="_token" value="{{ csrf_token() }}">
		<h2>Kaart bewerken</h2>
	</div>
	<div id="map"></div>
	
	<div class="toolbar clearfix">
		<div class="buttons bottom">
			<button class="button add" title="Bewerken"><i class="fa fa-cogs" aria-hidden="true"></i> Opslaan</button>
			<a class="button" href="{{ route('pages.edit', [$pageContent->page_id]) }}"><i class="fa fa-times" aria-hidden="true"></i> Terug</a>
		</div>
	</div>
</form>
@endsection


@section('javascript')
<script type="text/javascript">
function initMap() {
	var pointLatLng = new google.maps.LatLng({{ $map->lat }}, {{ $map->lng }});

	var map = new google.maps.Map(document.id('map'), {
		zoom: {{ $map->zoom }},
		center: pointLatLng
	});

	var marker = new google.maps.Marker({
		position: pointLatLng,
		map: map,
		title: {{ $map->name }}
	});
}
</script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBBC09E7Kd_cgBRpLjGZM4WseHTWVvCKLo&callback=initMap"></script>
@endsection