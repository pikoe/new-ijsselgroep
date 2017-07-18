@extends('layouts.web')

@section('content')
<ul class="breadcrumbs clearfix">
	<li class="home"><a href="/">Home</a></li>
	<li><a href="{{ route('articles') }}">Artikelen</a></li>
	<li><a href="{{ route('article', [$article->url]) }}">{{ $article->title }}</a></li>
</ul>
<div class="page-block">{!! $article->text !!}</div>
<div class="page-block">
	<a class="continue" href="{{ route('articles') }}">Lees alle artikelen</a>
</div>
@endsection

