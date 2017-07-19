@extends('layouts.admin')

@section('content')
<form class="form" action="{{ route('events.add') }}" method="POST">
	<div class="toolbar clearfix">
		<input type="hidden" name="_token" value="{{ csrf_token() }}">
		<h2>Activiteit toevoegen</h2>
	</div>
	
	<div class="input">
		<label for="name">Naam activiteit</label>
		<input name="name" id="name" value="{{ old('name') }}" size="45" required>
	</div>
	<div class="input">
		<label for="start">Start</label>
		<input name="start" id="start" value="{{ old('start', $start->format('d-m-Y H:i')) }}" size="45" required pattern="(0[1-9]|[12][0-9]|3[01])-(0[1-9]|1[012])-[12][0-9]{3} [0-5][0-9]:[0-5][0-9]" data-pattern-msg="Vul een datum en tijd in, als dd-mm-jjjj uu:mm">
	</div>
	<div class="input">
		<label for="end">Eind</label>
		<input name="end" id="end" value="{{ old('end', $end->format('d-m-Y H:i')) }}" size="45" required pattern="(0[1-9]|[12][0-9]|3[01])-(0[1-9]|1[012])-[12][0-9]{3} [0-5][0-9]:[0-5][0-9]" data-pattern-msg="Vul een datum en tijd in, als dd-mm-jjjj uu:mm">
	</div>
	
	
	<div class="input">
		<label>Groepen</label>
		<ul class="select-list">
		@foreach($groups->get() as $group)
			<li>
				<input type="checkbox" id="group_{{ $group->id }}" name="groups[]" value="{{ $group->id }}"{{ in_array($group->id, old('groups', []))?' checked':'' }}>
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
				<input type="checkbox" id="location_{{ $location->id }}" name="locations[]" value="{{ $location->id }}"{{ in_array($location->id, old('locations', []))?' checked':'' }}>
				<label for="location_{{ $location->id }}">{{ $location->name }}</label>
			</li>
		@endforeach
		</ul>
	</div>
	
	<div class="toolbar clearfix">
		<div class="buttons bottom">
			<button class="button add" title="Toevoegen" name="return" value="index"><i class="fa fa-reply" aria-hidden="true"></i> Toevoegen en terug naar overzicht</button>
			<button class="button add" title="Toevoegen"><i class="fa fa-plus" aria-hidden="true"></i> Toevoegen</button>
			<a class="button back" href="{{ route('events.index') }}"><i class="fa fa-times" aria-hidden="true"></i> Annuleren</a>
		</div>
	</div>
</form>
@endsection