@extends('layouts.admin')

@section('crumbs')
<a href="{{ route('articles.index') }}">Artikelen</a>
<a href="{{ route('articles.edit', [$article->id]) }}">{{ $article->name }}</a>
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
