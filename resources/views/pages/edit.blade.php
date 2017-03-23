@extends('layouts.admin')

@section('content')
<form class="form" action="{{ route('pages.edit', [$page->id]) }}" method="POST">
	<div class="toolbar clearfix">
		<input type="hidden" name="_token" value="{{ csrf_token() }}">
		<h2>Pagina toevoegen</h2>
	</div>
	
	<div class="input">
		<label for="name">Pagina naam</label>
		<input name="name" id="name" value="{{ old('name', $page->name) }}" size="45" required>
	</div>
	<div class="input">
		<label for="url">Pagina url</label>
		<input name="url" id="url" value="{{ old('url', $page->url) }}" size="45" required pattern="[a-z0-9\-]+" data-pattern-msg="Gebruik alleen kleine letters, cijfers of koppelstreepjes">
	</div>
	
	<div class="toolbar clearfix">
		<div class="buttons bottom">
			<button class="button add" title="Bewerken"><i class="fa fa-cogs" aria-hidden="true"></i> Bewerken</button>
			<a class="button" href="{{ route('pages.index') }}"><i class="fa fa-times" aria-hidden="true"></i> Annuleren</a>
		</div>
	</div>
</form>
@endsection