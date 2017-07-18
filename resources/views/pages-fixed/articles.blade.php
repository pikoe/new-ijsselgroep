@extends('layouts.web')

@section('title', 'Artikelen')

@section('content')
<ul class="breadcrumbs clearfix">
	<li class="home"><a href="/">Home</a></li>
	<li><a href="{{ route('articles') }}">Artikelen</a></li>
</ul>
	@foreach($articles as $key => $article)
		<div class="page-block">
			@if($article->activity_area)
			<img class="right-into-image" src="img/activiteitengebieden/{{ $article->activity_area }}.png" alt="{{ \App\Models\ActivityArea::$list[$article->activity_area] }}">
			@endif
			<h2>{{ $article->title }}</h2>
			{{ $article->created_at->formatLocalized('%e %B %Y') }}
			{!! $article->intro !!}
			{!! $article->text !== null ? '<a class="continue" href="' . route('article', [$article->url]) . '">Lees verder</a>' : '' !!}
		</div>
	@endforeach
	{{ $articles->links() }}
@endsection

