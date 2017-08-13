@extends('layouts.admin')

@section('content')
<form class="form" action="{{ route('events.edit', $event->id) }}" method="POST">
	<div class="toolbar clearfix">
		<input type="hidden" name="_token" value="{{ csrf_token() }}">
		<h2>Activiteit toevoegen</h2>
		<div class="buttons">
			<a id="delete-event" class="button delete" href="{{ route('events.delete', $event->id) }}"><i class="fa fa-trash-o" aria-hidden="true"></i> Verwijderen</a>
		</div>
	</div>
	
	<div class="input">
		<label for="name">Naam activiteit</label>
		<input name="name" id="name" value="{{ old('name', $event->name) }}" size="45" required>
	</div>
	<div class="input">
		<label for="start">Start</label>
		<input name="start" id="start" value="{{ old('start', $event->start->format('d-m-Y H:i')) }}" size="45" required pattern="(0[1-9]|[12][0-9]|3[01])-(0[1-9]|1[012])-[12][0-9]{3} [0-5][0-9]:[0-5][0-9]" data-pattern-msg="Vul een datum en tijd in, als dd-mm-jjjj uu:mm">
	</div>
	<div class="input">
		<label for="end">Eind</label>
		<input name="end" id="end" value="{{ old('end', $event->end->format('d-m-Y H:i')) }}" size="45" required pattern="(0[1-9]|[12][0-9]|3[01])-(0[1-9]|1[012])-[12][0-9]{3} [0-5][0-9]:[0-5][0-9]" data-pattern-msg="Vul een datum en tijd in, als dd-mm-jjjj uu:mm">
	</div>
	
	
	<div class="input">
		<label>Groepen</label>
		<ul class="select-list">
		@foreach($groups->get() as $group)
			<li>
				<input type="checkbox" id="group_{{ $group->id }}" name="groups[]" value="{{ $group->id }}"{{ in_array($group->id, old('groups', $event->groups()->allRelatedIds()->toArray()))?' checked':'' }}>
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
				<input type="checkbox" id="location_{{ $location->id }}" name="locations[]" value="{{ $location->id }}"{{ in_array($location->id, old('locations', $event->locations()->allRelatedIds()->toArray()))?' checked':'' }}>
				<label for="location_{{ $location->id }}">{{ $location->name }}</label>
			</li>
		@endforeach
		</ul>
	</div>
	
	<div class="input textarea">
		<label for="public_text">Publieke tekst</label>
		<textarea class="editor" name="public_text" id="public_text">{{ old('public_text', $event->public_text) }}</textarea>
	</div>
	<div class="input textarea">
		<label for="private_text">Alleen na inloggen</label>
		<textarea class="editor" name="private_text" id="private_text">{{ old('private_text', $event->private_text) }}</textarea>
	</div>
	
	<div class="toolbar clearfix">
		<div class="buttons bottom">
			<button class="button add" title="Bewerken" name="return" value="index"><i class="fa fa-reply" aria-hidden="true"></i> Opslaan en terug naar overzicht</button>
			<button class="button add" title="Bewerken"><i class="fa fa-cogs" aria-hidden="true"></i> Bewerken</button>
			<a class="button back" href="{{ route('events.index') }}"><i class="fa fa-times" aria-hidden="true"></i> Terug</a>
		</div>
	</div>
</form>
@endsection

@section('javascript')
<script type="text/javascript">
	document.id('delete-event').addEvent('click', function(event){
		event.preventDefault();
		event.currentTarget = this;
		new Confirm('Wilt u deze activiteit verwijderen?', function() {
			new Request({
				url: event.currentTarget.href,
				data: {
					_token: '{{ csrf_token() }}'
				},
				onSuccess: function() {
					location.href = '{{ route('events.index') }}';
				}
			}).post();
		}, function() {});
	});
</script>
@endsection
