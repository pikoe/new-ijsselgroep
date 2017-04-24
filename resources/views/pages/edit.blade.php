@extends('layouts.admin')

@section('content')
<form class="form" action="{{ route('pages.edit', [$page->id]) }}" method="POST">
	<div class="toolbar clearfix">
		<input type="hidden" name="_token" value="{{ csrf_token() }}">
		<h2>Pagina toevoegen</h2>
		<div class="buttons">
			<a id="delete-page" class="button delete" href="{{ route('pages.delete', $page->id) }}"><i class="fa fa-trash-o" aria-hidden="true"></i> Verwijderen</a>
		</div>
	</div>
	
	<div class="input">
		<label for="title">Menu titel</label>
		<input name="title" id="title" value="{{ old('title', $page->title) }}" size="45" required>
	</div>
	<div class="input">
		<label for="sub_title">Ondertitel</label>
		<input name="sub_title" id="sub_title" value="{{ old('sub_title', $page->sub_title) }}" size="45" required>
	</div>
	<div class="input">
		<label for="name">Pagina naam</label>
		<input name="name" id="name" value="{{ old('name', $page->name) }}" size="45" required>
	</div>
	<div class="input">
		<label for="url">Pagina url</label>
		<input name="url" id="url" value="{{ old('url', $page->url) }}" size="45" required pattern="[a-z0-9\-]+" data-pattern-msg="Gebruik alleen kleine letters, cijfers of koppelstreepjes">
	</div>
	
	<div class="page-content">
		<textarea class="editor" name="text" id="text">{{ old('text', $page->text) }}</textarea>
	</div>
	
	<div class="toolbar clearfix">
		<div class="buttons bottom">
			<button class="button add" title="Bewerken"><i class="fa fa-cogs" aria-hidden="true"></i> Bewerken</button>
			<a class="button" href="{{ route('pages.index') }}"><i class="fa fa-times" aria-hidden="true"></i> Annuleren</a>
		</div>
	</div>
</form>
@endsection

@section('javascript')
<script type="text/javascript">
	document.id('delete-page').addEvent('click', function(event) {
		event.preventDefault();
		event.currentTarget = this;
		new Confirm('Wilt u deze pagina en eventuele subpaginas verwijderen?', function() {
			new Request({
				url: event.currentTarget.href,
				data: {
					_token: '{{ csrf_token() }}'
				},
				onSuccess: function() {
					location.href = '{{ route('pages.index') }}';
				}
			}).post();
		}, function() {});
	});
	document.id('name').addEvent('keyup', function() {
		document.id('url').value = this.value.toLowerCase().replace(/[^0-9a-z]+/g, '-');
	});
</script>
@endsection
