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
		<label for="type">Weergave type</label>
		<select name="type" id="type">
			<option value="">Kies een weergave type</option>
			@foreach(\App\Models\Content\ArticleSlot::$type as $type => $name)
			<option value="{{ $type }}"{{ ($type == old('type', $article_slot->type) ? ' selected' : '') }}>{{ $name }}</option>
			@endforeach
		</select>
	</div>
	<div class="input">
		<label for="group_id">Groep</label>
		<select name="group_id" id="group_id">
			<option value="">Geen filtering op groep</option>
			@foreach($groups->get() as $group)
			<option value="{{ $group->id }}"{{ ($group->id == old('group_id', $article_slot->group_id) ? ' selected' : '') }}>{{ $group->name }}</option>
			@endforeach
		</select>
	</div>
	
	<div class="toolbar clearfix">
		<div class="buttons bottom">
			<button class="button add" title="Bewerken" name="return" value="index"><i class="fa fa-reply" aria-hidden="true"></i> Opslaan en terug naar pagina</button>
			<button class="button add" title="Bewerken"><i class="fa fa-cogs" aria-hidden="true"></i> Opslaan</button>
			<a class="button back" href="{{ route('pages.edit', [$pageContent->page_id]) }}"><i class="fa fa-times" aria-hidden="true"></i> Terug</a>
		</div>
	</div>
</form>
@endsection