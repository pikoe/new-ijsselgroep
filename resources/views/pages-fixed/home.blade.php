@extends('layouts.web')

@section('title', 'Home')

@section('content')
<ul class="breadcrumbs clearfix">
	<li class="home"><a href="/">Home</a></li>
</ul>
	<div class="page-block">
		<h1>Scouting IJsselgroep</h1>
		<h2>Jongens scoutinggroep in Gorssel</h2>
		<h3>Al meer dan 70 jaar</h3>
		<p><a href="pdf">PDF maken</a></p>
	</div>
	
	@foreach($articles as $key => $article)
		@if($key %2 == 0)
		<div class="page-area">
			<div class="page-row">
		@endif
		<div class="page-block">
			@if($article->images()->count())
				<a class="article-image" href="{{ route('article', [$article->url]) }}">
					@php
					$image = $article->images()->first();
					@endphp
					<img src="{{ $image->resize(370, 370, true) }}"  width="370" height="370" alt="{{ $image->alt }}" title="{{ $image->title }}">
				</a>
			@endif
			<div>
				@if($article->activity_area)
				<img class="right-into-image" src="img/activiteitengebieden/{{ $article->activity_area }}.png" alt="{{ \App\Models\ActivityArea::$list[$article->activity_area] }}">
				@endif
				<h2>{{ $article->title }}</h2>
				{{ $article->created_at->formatLocalized('%e %B %Y') }}
				{!! $article->intro !!}
				{!! $article->text !== null || $article->images()->count() ? '<a class="continue button" href="' . route('article', [$article->url]) . '">Lees verder</a>' : '' !!}
			</div>
			<div class="clearfix"></div>
		</div>
		@if($key %2 == 1)
			</div>
		</div>
		@endif
	@endforeach
	@if(count($articles) && count($articles) %2 == 1)
			<div class="page-block">
				<h2>Oudere berichten</h2>
				
				@foreach($older_articles as $article)
				<div><a href="{{ route('article', [$article->url]) }}">{{ $article->title }}</a></div>
				@endforeach
				
				<a class="continue button" href="{{ route('articles') }}">Lees alle berichten en verslagen</a>
			</div>
		</div>
	</div>
	@endif
	
@endsection

