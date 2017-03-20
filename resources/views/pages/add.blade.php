@extends('layouts.admin')

@section('content')
<form class="form" action="{{ route('pages.add') }}" method="POST">
	<div class="toolbar clearfix">
		<input type="hidden" name="_token" value="H6sg46pRkQvrdONxHNHKTAwEVuS2qAV6WjtlrlTP">
		<h2>Pagina toevoegen</h2>
	</div>
	
	<div class="input">
		<label for="name">Pagina naam</label>
		<input name="name" id="name" value="{{ old('name') }}" size="45" required>
	</div>
	<div class="input">
		<label for="url">Pagina url</label>
		<input name="url" id="url" value="{{ old('url') }}" size="45" required pattern="[a-z0-9\-]+" data-pattern-msg="Gebruik alleen kleine letters, cijfers of koppelstreepjes">
	</div>
	
	<div class="toolbar clearfix">
		<div class="buttons bottom">
			<button class="button add" title="Toevoegen"><i class="fa fa-plus" aria-hidden="true"></i> Toevoegen</button>
			<a class="button" href="{{ route('pages') }}"><i class="fa fa-times" aria-hidden="true"></i> Annuleren</a>
		</div>
	</div>
</form>
@endsection