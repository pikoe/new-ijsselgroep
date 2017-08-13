@extends('layouts.admin')

@section('crumbs')
<a href="{{ route('articles.index') }}">Artikelen</a>
<a href="{{ route('articles.add') }}">Artikel toevoegen</a>
@endsection

@section('content')
<form class="form" action="{{ route('articles.add') }}" method="POST">
	<div class="toolbar clearfix">
		<input type="hidden" name="_token" value="{{ csrf_token() }}">
		<h2>Artikel toevoegen</h2>
	</div>
	
	<div class="input">
		<label for="title">Titel</label>
		<input name="title" id="title" value="{{ old('title') }}" size="45" required>
	</div>
	<div class="input">
		<label for="url">Artikel url</label>
		<input name="url" id="url" value="{{ old('url') }}" size="45" required pattern="[a-z0-9\-]+" data-pattern-msg="Gebruik alleen kleine letters, cijfers of koppelstreepjes">
	</div>
	
	<div class="input">
		<label for="event_id">Activiteit</label>
		<select name="event_id" id="event_id">
			<option value="">Kies een activiteit</option>
			@foreach($events->get() as $event)
			<option value="{{ $event->id }}"{{ ($event->id == old('event_id') ? ' selected' : '') }}>{{ $event->name }}</option>
			@endforeach
		</select>
	</div>
	<div class="input">
		<label for="activity_area">Activiteitengebied</label>
		<select name="activity_area" id="activity_area">
			<option value="">Kies een activiteitengebied</option>
			@foreach(\App\Models\ActivityArea::$list as $activity_area => $name)
			<option value="{{ $activity_area }}"{{ ($activity_area == old('activity_area') ? ' selected' : '') }}>{{ $name }}</option>
			@endforeach
		</select>
	</div>
	<div class="input">
		<label>Groep</label>
		<ul class="radio-list">
			<li>
				<input type="radio" id="group_0" name="group_id" value=""{{ null == old('group_id')?' checked':'' }}>
				<label for="group_0">Geen</label>
			</li>
		@foreach($groups->get() as $group)
			<li>
				<input type="radio" id="group_{{ $group->id }}" name="group_id" value="{{ $group->id }}"{{ $group->id == old('group_id')?' checked':'' }}>
				<label for="group_{{ $group->id }}">{{ $group->name }}</label>
			</li>
		@endforeach
		</ul>
	</div>
	<div class="input">
		<label>Locatie</label>
		<ul class="radio-list">
			<li>
				<input type="radio" id="location_0" name="location_id" value=""{{ null == old('location_id')?' checked':'' }}>
				<label for="location_0">Geen</label>
			</li>
		@foreach($locations->get() as $location)
			<li>
				<input type="radio" id="location_{{ $location->id }}" name="location_id" value="{{ $location->id }}"{{ $location->id == old('location_id')?' checked':'' }}>
				<label for="location_{{ $location->id }}">{{ $location->name }}</label>
			</li>
		@endforeach
		</ul>
	</div>
	
	<div class="input textarea">
		<label for="intro">Intro</label>
		<textarea class="editor" name="intro" id="intro">{{ old('intro') }}</textarea>
	</div>
	<div class="input textarea">
		<label for="text">Volledig</label>
		<textarea class="editor" name="text" id="text">{{ old('text') }}</textarea>
	</div>
	
	<div class="toolbar clearfix">
		<div class="buttons bottom">
			<button class="button add" title="Bewerken" name="return" value="index"><i class="fa fa-reply" aria-hidden="true"></i> Opslaan en terug naar overzicht</button>
			<button class="button add" title="Toevoegen"><i class="fa fa-plus" aria-hidden="true"></i> Toevoegen</button>
			<a class="button back" href="{{ route('articles.index') }}"><i class="fa fa-times" aria-hidden="true"></i> Annuleren</a>
		</div>
	</div>
</form>
@endsection

@section('javascript')
<script type="text/javascript">
	document.id('title').addEvent('keyup', function() {
		document.id('url').value = this.value.toLowerCase().replace(/[^0-9a-z]+/g, '-');
	});
</script>
@endsection
