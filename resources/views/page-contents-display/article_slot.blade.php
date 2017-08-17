@if($article)
	@if($article->images()->count())
		<a class="article-image" href="{{ route('article', [$article->url]) }}">
			@php
			$image = $article->images()->first();
			@endphp
			<img src="{{ $image->resize(370, 370, true) }}" width="370" height="370" alt="{{ $image->alt }}" title="{{ $image->title }}">
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
@else
	Geen bericht of verslag gevonden
@endif