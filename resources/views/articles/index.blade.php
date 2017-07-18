@extends('layouts.admin')


@section('crumbs')
<a href="{{ route('articles.index') }}">Artikelen</a>
@endsection

@section('content')
<div class="form">
	<div class="toolbar clearfix">
		<h2>Artikelen</h2>
		<div class="buttons">
			<a class="button add" href="{{ route('articles.add') }}"><i class="fa fa-plus" aria-hidden="true"></i> Toevoegen</a>
		</div>
	</div>
	
	<table class="list" id="articles">
		<thead>
			<tr>
				<th>Titel</th>
				<th>Aangemaakt</th>
				<th>Gewijzigd</th>
				<th class="actions">&nbsp;</th>
			</tr>
		</thead>
		<tbody>
			@foreach($articles as $article)
			<tr>
				<td>{{ $article->title }}</td>
				<td>{{ $article->created_at->format('Y-m-d H:i') }}</td>
				<td>{{ $article->updated_at->format('Y-m-d H:i') }}</td>
				<td class="actions">
					<a class="button edit" href="{{ route('articles.edit', $article->id) }}"><i class="fa fa-cogs" aria-hidden="true"></i> Bewerken</a>
					<a class="button delete" href="{{ route('articles.delete', $article->id) }}"><i class="fa fa-trash-o" aria-hidden="true"></i> Verwijderen</a>
				</td>
			</tr>
			@endforeach
		</tbody>
	</table>
	{{ $articles->links() }}
</div>
@endsection

@section('javascript')
<script type="text/javascript">
	document.getElements('table.list tbody tr').addEvent('click', function(e) {
		if(e.target.nodeName.toLowerCase() != 'a') {
			window.location = this.getElement('a.button.edit').href;
		}
	});
	
	document.id('articles').addEvent('click:relay(.button.delete)', function(event){
		event.preventDefault();
		var url = this.href;
		new Confirm('Wilt u dit artikel verwijderen?', function() {
			new Request({
				url: url,
				data: {
					_token: '{{ csrf_token() }}'
				},
				onSuccess: function() {
					location.href = '{{ route('articles.index') }}';
				}
			}).post();
		}, function() {});
	});
</script>
@endsection
