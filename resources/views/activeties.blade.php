@extends('layouts.web')

@section('content')
<ul class="breadcrumbs clearfix">
	<li class="home"><a href="/">Home</a></li>
	<li><a href="activiteiten">Activiteiten</a></li>
	<li><a href="activiteiten/kalender">Kalender</a></li>
</ul>
<div class="article-page">
	<h1>Activiteiten</h1>
	<p>Hier een overzicht van de activiteiten in de komende periode, let op dat dit overzicht niet ten alle tijde actueel zal zijn.<br>
		Houd ook de nieuwsbrief via de mail in de gaten</p>
	<table class="calendar">
		<thead>
			<tr>
				<th class="week">&nbsp;</th>
				<th>Ma</th>
				<th>Di</th>
				<th>Wo</th>
				<th>Do</th>
				<th>Vr</th>
				<th>Za</th>
				<th>Zo</th>
			</tr>
		</thead>
		<tbody>
			@while($date->lte($end))
			<tr>
				<th class="week-number">{{ $date->weekOfYear }}</th>
				@for($w = $date->weekOfYear; $w == $date->weekOfYear; $date->addDay())
				<td>{{ $date->day }}</td>
				@endfor
			</tr>
			@endwhile
		</tbody>
	</table>
</div>
@endsection