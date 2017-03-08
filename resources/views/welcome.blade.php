@extends('layouts.web')

@section('content')
<ul class="breadcrumbs clearfix">
	<li class="home"><a href="/">Home</a></li>
</ul>
<div class="article-page">
	<h1>Scouting IJsselgroep Gorssel</h1>
	<h2>Jongens scoutinggroep in Gorssel</h2>
	<h3>Al meer dan 70 jaar</h3>
	<p><a href="article">Leiding gezocht</a></p>
	<p><a href="pdf">PDF maken</a></p>
	<p>{{ strftime('%e %B %Y') }}</p>
	<p>{!! str_repeat('Content 123<br>', 100) !!}</p>
	
</div>
@endsection