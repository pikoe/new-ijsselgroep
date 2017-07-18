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
	
	<div class="input textarea">
		<label for="intro">Intro</label>
		<textarea class="editor" name="intro">{{ old('intro') }}</textarea>
	</div>
	<div class="input textarea">
		<label for="text">Volledig</label>
		<textarea class="editor" name="text">{{ old('text') }}</textarea>
	</div>
	
	<div class="toolbar clearfix">
		<div class="buttons bottom">
			<button class="button add" title="Toevoegen"><i class="fa fa-plus" aria-hidden="true"></i> Toevoegen</button>
			<a class="button" href="{{ route('articles.index') }}"><i class="fa fa-times" aria-hidden="true"></i> Annuleren</a>
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
