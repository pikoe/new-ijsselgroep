@extends('layouts.admin')

@section('crumbs')
<a href="{{ route('pages.index') }}">Pagina's</a>
<a href="{{ route('pages.edit', [$pageContent->page_id]) }}">{{ $pageContent->page->name }}</a>
<a href="{{ route('pagecontents.edit', [$pageContent->id]) }}">Artikel slot</a>
@endsection

@section('content')
<form class="form" action="{{ route('pagecontents.edit', [$pageContent->id]) }}" method="POST">
	<div class="toolbar clearfix">
		<input type="hidden" name="_token" value="{{ csrf_token() }}">
		<h2>Artikel slot instellingen bewerken</h2>
	</div>
	
	<div class="input">
		<label for="activity_area">TODO:: type slot</label>
		<select name="activity_area" id="activity_area">
			<option value="">Kies een activiteitengebied</option>
			@foreach(\App\Models\ActivityArea::$list as $activity_area => $name)
			<option value="{{ $activity_area }}"{{ ($activity_area == old('activity_area') ? ' selected' : '') }}>{{ $name }}</option>
			@endforeach
		</select>
	</div>
	<div class="input">
		<label>TODO:: Groep</label>
		<ul class="select-list">
		@foreach($groups->get() as $group)
			<li>
				<input type="checkbox" id="group_{{ $group->id }}" name="groups[]" value="{{ $group->id }}"{{ $group->id == old('groups')?' checked':'' }}>
				<label for="group_{{ $group->id }}">{{ $group->name }}</label>
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