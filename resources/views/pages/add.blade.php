@extends('layouts.admin')

@section('crumbs')
<a href="{{ route('pages.index') }}">Pagina's</a>
<a href="{{ route('pages.add') }}">Pagina toevoegen</a>
@endsection

@section('content')
<form class="form" action="{{ route('pages.add') }}" method="POST">
	<div class="toolbar clearfix">
		<input type="hidden" name="_token" value="{{ csrf_token() }}">
		<h2>Pagina toevoegen</h2>
	</div>
	
	<div class="input">
		<label for="title">Menu titel</label>
		<input name="title" id="title" value="{{ old('title') }}" size="45" required>
	</div>
	<div class="input">
		<label for="sub_title">Ondertitel</label>
		<input name="sub_title" id="sub_title" value="{{ old('sub_title') }}" size="45" required>
	</div>
	<div class="input">
		<label for="name">Pagina naam</label>
		<input name="name" id="name" value="{{ old('name') }}" size="45" required>
	</div>
	<div class="input">
		<label for="url">Pagina url</label>
		<input name="url" id="url" value="{{ old('url') }}" size="45" required pattern="[a-z0-9\-]+" data-pattern-msg="Gebruik alleen kleine letters, cijfers of koppelstreepjes">
	</div>
	
	<div class="input">
		<label for="layout">Layout</label>
		<select name="layout" id="layout" required>
			<option value="">Kies een layout</option>
			@foreach($layouts as $layout)
			<option{{ (old('layout') == $layout ? ' selected' : '') }}>{{ $layout }}</option>
			@endforeach
		</select>
	</div>
	
	<div class="toolbar clearfix">
		<div class="buttons bottom">
			<button class="button add" title="Toevoegen" name="return" value="index"><i class="fa fa-reply" aria-hidden="true"></i> Toevoegen en terug naar overzicht</button>
			<button class="button add" title="Toevoegen"><i class="fa fa-plus" aria-hidden="true"></i> Toevoegen</button>
			<a class="button back" href="{{ route('pages.index') }}"><i class="fa fa-times" aria-hidden="true"></i> Annuleren</a>
		</div>
	</div>
</form>
@endsection

@section('javascript')
<script type="text/javascript">
	document.id('name').addEvent('keyup', function() {
		document.id('url').value = this.value.toLowerCase().replace(/[^0-9a-z]+/g, '-');
	});
</script>
@endsection
