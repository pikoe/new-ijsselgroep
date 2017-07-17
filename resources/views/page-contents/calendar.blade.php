@extends('layouts.admin')

@section('crumbs')
<a href="{{ route('pages.index') }}">Pagina's</a>
<a href="{{ route('pages.edit', [$pageContent->page_id]) }}">{{ $pageContent->page->name }}</a>
<a href="{{ route('pagecontents.edit', [$pageContent->id]) }}">Kalender</a>
@endsection

@section('content')
<form class="form" action="{{ route('pagecontents.edit', [$pageContent->id]) }}" method="POST">
	<div class="toolbar clearfix">
		<input type="hidden" name="_token" value="{{ csrf_token() }}">
		<h2>Kalender instellingen bewerken</h2>
	</div>
	
	<div class="input">
		<label>Groepen</label>
		<ul class="select-list">
		@foreach($groups->get() as $group)
			<li>
				<input type="checkbox" id="group_{{ $group->id }}" name="groups[]" value="{{ $group->id }}"{{ in_array($group->id, old('groups', $calendar->groups()->allRelatedIds()->toArray()))?' checked':'' }}>
				<label for="group_{{ $group->id }}">{{ $group->name }}</label>
			</li>
		@endforeach
		</ul>
	</div>
	
	<div class="input">
		<label>Locaties</label>
		<ul class="select-list">
		@foreach($locations->get() as $location)
			<li>
				<input type="checkbox" id="location_{{ $location->id }}" name="locations[]" value="{{ $location->id }}"{{ in_array($location->id, old('locations', $calendar->locations()->allRelatedIds()->toArray()))?' checked':'' }}>
				<label for="location_{{ $location->id }}">{{ $location->name }}</label>
			</li>
		@endforeach
		</ul>
	</div>
	
	
	<div class="toolbar clearfix">
		<div class="buttons bottom">
			<button class="button add" title="Bewerken"><i class="fa fa-cogs" aria-hidden="true"></i> Opslaan</button>
			<a class="button" href="{{ route('pages.edit', [$pageContent->page_id]) }}"><i class="fa fa-times" aria-hidden="true"></i> Terug</a>
		</div>
	</div>
</form>
@endsection