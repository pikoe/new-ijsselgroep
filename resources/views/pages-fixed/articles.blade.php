@extends('layouts.web')

@section('content')
<ul class="breadcrumbs clearfix">
	<li class="home"><a href="/">Home</a></li>
	<li><a href="{{ route('articles') }}">Artikelen</a></li>
</ul>
	@foreach($articles as $key => $article)
		<div class="page-block">
			<h2>{{ $article->title }}</h2>
			{{ $article->created_at->formatLocalized('%e %B %Y') }}
			{!! $article->intro !!}
			{!! $article->text !== null ? '<a class="continue" href="' . route('article', [$article->url]) . '">Lees verder</a>' : '' !!}
		</div>
	@endforeach
	{{ $articles->links() }}
@endsection

