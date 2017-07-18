@extends('layouts.web')

@section('content')
<ul class="breadcrumbs clearfix">
	<li class="home"><a href="/">Home</a></li>
</ul>
	<h1>Scouting IJsselgroep Gorssel</h1>
	<h2>Jongens scoutinggroep in Gorssel</h2>
	<h3>Al meer dan 70 jaar</h3>
	<p><a href="article">Leiding gezocht</a></p>
	<p><a href="pdf">PDF maken</a></p>
	
	
	
	@foreach($articles as $key => $article)
		@if($key %2 == 0)
		<div class="page-area">
			<div class="page-row">
		@endif
		<div class="page-block">
			<h2>{{ $article->title }}</h2>
			{{ $article->created_at->formatLocalized('%e %B %Y') }}
			{!! $article->intro !!}
			{!! $article->text !== null ? '<a class="continue" href="' . route('article', [$article->url]) . '">Lees verder</a>' : '' !!}
		</div>
		@if($key %2 == 1)
			</div>
		</div>
		@endif
	@endforeach
	@if(count($articles) && count($articles) %2 == 1)
			<div class="page-block">
				<a class="continue" href="{{ route('articles') }}">Lees alle artikelen</a>
			</div>
		</div>
	</div>
	@endif
	
@endsection

