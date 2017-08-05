@extends('layouts.web')

@section('title', 'Artikelen')

@section('content')
<ul class="breadcrumbs clearfix">
	<li class="home"><a href="/">Home</a></li>
	<li><a href="{{ url('activiteiten') }}">Activiteiten</a></li>
	<li><a href="{{ route('articles') }}">Berichten en verslagen</a></li>
</ul>
	@foreach($articles as $key => $article)
		<div class="page-block">
			@if($article->images()->count())
				<a class="article-image" href="{{ route('article', [$article->url]) }}">
					@php
					$image = $article->images()->first();
					@endphp
					<img src="{{ $image->resize(370, 370, true) }}" alt="{{ $image->alt }}" title="{{ $image->title }}">
				</a>
			@endif
			<div>
				@if($article->activity_area)
				<img class="right-into-image" src="img/activiteitengebieden/{{ $article->activity_area }}.png" alt="{{ \App\Models\ActivityArea::$list[$article->activity_area] }}">
				@endif
				<h2>{{ $article->title }}</h2>
				{{ $article->created_at->formatLocalized('%e %B %Y') }}
				{!! $article->intro !!}
				{!! $article->text !== null || $article->images()->count() ? '<a class="continue" href="' . route('article', [$article->url]) . '">Lees verder</a>' : '' !!}
			</div>
			<div class="clearfix"></div>
		</div>
	@endforeach
	{{ $articles->links() }}
@endsection

