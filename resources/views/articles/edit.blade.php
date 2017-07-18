@extends('layouts.admin')

@section('crumbs')
<a href="{{ route('articles.index') }}">Artikelen</a>
<a href="{{ route('articles.edit', [$article->id]) }}">{{ $article->title }}</a>
@endsection

@section('content')
<form class="form" action="{{ route('articles.edit', [$article->id]) }}" method="POST">
	<div class="toolbar clearfix">
		<input type="hidden" name="_token" value="{{ csrf_token() }}">
		<h2>Artikel bewerken</h2>
		<div class="buttons">
			<a id="delete-article" class="button delete" href="{{ route('articles.delete', $article->id) }}"><i class="fa fa-trash-o" aria-hidden="true"></i> Verwijderen</a>
		</div>
	</div>
	
	<div class="input">
		<label for="title">Titel</label>
		<input name="title" id="title" value="{{ old('title', $article->title) }}" size="45" required>
	</div>
	<div class="input">
		<label for="url">Artikel url</label>
		<input name="url" id="url" value="{{ old('url', $article->url) }}" size="45" required pattern="[a-z0-9\-]+" data-pattern-msg="Gebruik alleen kleine letters, cijfers of koppelstreepjes">
	</div>
	
	<div class="input">
		<label for="event_id">Activiteit</label>
		<select name="event_id" id="event_id">
			<option value="">Kies een activiteit</option>
			@foreach($events->get() as $event)
			<option value="{{ $event->id }}"{{ ($event->id == old('event_id', $article->event_id) ? ' selected' : '') }}>{{ $event->name }}</option>
			@endforeach
		</select>
	</div>
	<div class="input">
		<label for="activity_area">Activiteitengebied</label>
		<select name="activity_area" id="activity_area">
			<option value="">Kies een activiteitengebied</option>
			@foreach(\App\Models\ActivityArea::$list as $activity_area => $name)
			<option value="{{ $activity_area }}"{{ ($activity_area == old('activity_area', $article->activity_area) ? ' selected' : '') }}>{{ $name }}</option>
			@endforeach
		</select>
	</div>
	<div class="input">
		<label>Groep</label>
		<ul class="radio-list">
		@foreach($groups->get() as $group)
			<li>
				<input type="radio" id="group_{{ $group->id }}" name="group_id" value="{{ $group->id }}"{{ $group->id == old('group_id', $article->group_id)?' checked':'' }}>
				<label for="group_{{ $group->id }}">{{ $group->name }}</label>
			</li>
		@endforeach
		</ul>
	</div>
	<div class="input">
		<label>Locatie</label>
		<ul class="radio-list">
		@foreach($locations->get() as $location)
			<li>
				<input type="radio" id="location_{{ $location->id }}" name="location_id" value="{{ $location->id }}"{{ $location->id == old('location_id', $article->location_id)?' checked':'' }}>
				<label for="location_{{ $location->id }}">{{ $location->name }}</label>
			</li>
		@endforeach
		</ul>
	</div>
	
	<div class="input textarea">
		<label for="intro">Intro</label>
		<textarea class="editor" name="intro">{{ old('intro', $article->intro) }}</textarea>
	</div>
	<div class="input textarea">
		<label for="text">Volledig</label>
		<textarea class="editor" name="text">{{ old('text', $article->text) }}</textarea>
	</div>
	
	<div class="toolbar clearfix">
		<div class="buttons bottom">
			<button class="button add" title="Bewerken"><i class="fa fa-cogs" aria-hidden="true"></i> Opslaan</button>
			<a class="button" href="{{ route('articles.index') }}"><i class="fa fa-times" aria-hidden="true"></i> Terug</a>
		</div>
	</div>
</form>
@endsection

@section('javascript')
<script type="text/javascript">
	document.id('delete-article').addEvent('click', function(e) {
		e.preventDefault();
		e.currentTarget = this;
		new Confirm('Wilt u dit artikel verwijderen?', function() {
			new Request({
				url: e.currentTarget.href,
				data: {
					_token: '{{ csrf_token() }}'
				},
				onSuccess: function() {
					location.href = '{{ route('articles.index') }}';
				}
			}).post();
		}, function() {});
	});
	document.id('title').addEvent('keyup', function() {
		document.id('url').value = this.value.toLowerCase().replace(/[^0-9a-z]+/g, '-');
	});
</script>
@endsection
