@extends('layouts.web')

@section('title', $article->title)

@section('content')
<ul class="breadcrumbs clearfix">
	<li class="home"><a href="/">Home</a></li>
	<li><a href="{{ url('activiteiten') }}">Activiteiten</a></li>
	<li><a href="{{ route('articles') }}">Berichten en verslagen</a></li>
	<li><a href="{{ route('article', [$article->url]) }}">{{ $article->title }}</a></li>
</ul>
<div class="page-block">{!! $article->text !== null ? $article->text : '<h2>' . $article->title . '</h2>' . $article->intro !!}</div>
@if($article->images()->count())
	<div class="page-block">
		<div class="clearfix image-gallery">
			@foreach($article->images()->get() as $image)
				<a class="article-image" href="{{ $image->resize(800, 800, false) }}" data-width="{{ $image->getWidht() }}" data-height="{{ $image->getHeight() }}">
					<img src="{{ $image->resize(250, 250, true) }}" width="250" height="250" alt="{{ $image->alt }}" title="{{ $image->title }}">
					<span class="text">{{ $image->title }}</span>
				</a>
			@endforeach
		</div>
	</div>
@endif
<div class="page-block">
	@if($article->group_id && $article->group->page_id)
	<a class="continue button" href="{{ url($article->group->page->full_url) }}">Meer over {{ $article->group->preposition_name }}</a>
	@endif
	<a class="continue button" href="{{ route('articles') }}">Lees alle berichten en verslagen</a>
</div>
@endsection

