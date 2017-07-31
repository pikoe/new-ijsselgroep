@extends('layouts.web')

@section('title', $article->title)

@section('content')
<ul class="breadcrumbs clearfix">
	<li class="home"><a href="/">Home</a></li>
	<li><a href="{{ route('articles') }}">Artikelen</a></li>
	<li><a href="{{ route('article', [$article->url]) }}">{{ $article->title }}</a></li>
</ul>
<div class="page-block">{!! $article->text !== null ? $article->text : '<h2>' . $article->title . '</h2>' . $article->intro !!}</div>
@if($article->images()->count())
	<div class="page-block">
		<div class="clearfix image-gallery">
			@foreach($article->images()->get() as $image)
				<a class="article-image" href="{{ $image->src }}" data-width="{{ $image->getWidht() }}" data-height="{{ $image->getHeight() }}">
					<img src="{{ $image->resize(250, 250, true) }}" alt="{{ $image->alt }}" title="{{ $image->title }}">
				</a>
			@endforeach
		</div>
	</div>
@endif
<div class="page-block">
	<a class="continue" href="{{ route('articles') }}">Lees alle artikelen</a>
</div>
@endsection

