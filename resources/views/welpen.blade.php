@extends('layouts.web')

@section('content')
<ul class="breadcrumbs clearfix">
	<li class="home"><a href="/">Home</a></li>
	<li><a href="leeftijdsgroepen">Leeftijdsgroepen</a></li>
	<li><a href="leeftijdsgroepen/welpen">Welpen</a></li>
</ul>
<div class="article-page">
	<img class="right-into-image" src="img/speltaktekens/welpen.png" alt="Speltakteken">
	<h1>Welpen</h1>
	<p>De welpen, scouts van 7 tot 11 jaar, spelen hun Scoutingspel in de jungle met Mowgli en Shanti.
		In het rimboeverhaal, dat zich afspeelt in India, is Mowgli opgenomen door de wolvenfamilie.
		Hij was de zoon van een houthakker. Samen met de welpen leren ze van de andere dieren en gaan ze op avontuur. 
		Zo is er Baloe de beer, die erg van eten houdt. Hij leert de kinderen alles over eten. Zo is er ook Bagheera, een zorgzaam type.
		Hij leert de welpen alles over EHBO en veiligheid. Elke opkomst komt er een ander junglefiguur langs bij de welpen!</p>
	<p>Veel opkomsten staan in het teken waarmee Scouting bekend is geworden.
		Denk hierbij aan primitief koken, houthakken, vuur maken, knopen, hutten bouwen, vlot varen, hiken en ga zo maar door!
		Naast dergelijke programma's wordt ook aandacht besteed aan het leren omgaan met risico's, die bijvoorbeeld ontstaan bij het maken van een vuurtje, EHBO en milieu.</p>
	<p>Enkele keren per jaar gaan we me de welpen op kamp. Het hoogte punt is altijd het Hemelvaartkamp.
		Hierbij gaan we naar een ander (Scouting)clubhuis in de regio en zijn daar 3 dagen waar we de meest leuke dingen doen.
		Het kamp staat elk jaar in het teken van een gaaf thema, zo hebben de welpen de afgelopen jaren bijvoorbeeld een Cowboy- en een Bokkerijderskamp gehad!
		Dit jaar gaan we naar Lochem waar we het kamp hebben in het clubgebouw van Scouting de Witte Wieven.
		In de voorbereiding hierop gaan we 1 tot 2 keer op weekendkamp. Bij dit kamp slapen we in ons eigen gebouw, <a href="verhuur/hordehol">het Hordehol</a>.
		Tijdens dit kamp doen we allemaal leuke dingen op en rond ons terrein.
		Verder is er nog de Jungledag, dit is een op een zaterdagmiddag waar alle welpen van meerdere Scoutinggroepen uit de regio aan meedoen.</p>
	<p>Onze welpen spelen het verhaal in en rond het Hordehol. Het Hordehol ziet er anders uit dan een echt Hordehol,
		het is een stenen gebouw met een grote ruimte waarin de verschillende spelletjes worden gedaan.
		Maar het de meeste dingen doen we buiten in het bos!</p>
	<p>Zodra een welp 11 jaar is mag hij overvliegen naar de scouts. We proberen altijd 2 of meer kinderen tegelijk over te laten vliegen zodat ze niet alleen overgaan.</p>
	<p>Omdat de ouders vaak de kinderen naar scouting brengen is er geregeld contact tussen de leiding en hen.
		Zodoende proberen we eventuele problemen voor te zijn. Mochten er ondanks dat nog problemen/vragen zijn kunt u altijd de leiding bellen of mailen.
		Tevens hebben wij elke laatste zaterdag van de maand een koffiemoment: ouders mogen dan een half uurtje eerder komen om een kopje koffie te komen drinken.</p>
	<p>Ben jij enthousiast geraakt? Kom gerust een zaterdagmiddag langs om een opkomst mee te draaien!
		Neem van tevoren wel even contact op met de leiding, zodat er rekening gehouden kan worden met je komst.</p>
</div>

<div class="article-area">
	<div class="article-row">
		<div class="article-page">
			<h2 class="icon info-list">In het kort</h2>
			<p><strong>De leiding:</strong></p>
			<ul>
				<li>Rudy Brummelman (Teamleider)</li>
				<li>Dave Schonewille</li>
				<li>Steven Hessing</li>
				<li><a href="#">Vacature</a></li>
			</ul>
			<p><strong>Contact:</strong> <a href="mailto:welpen@scouting-ijsselgroep.nl">welpen@scouting-ijsselgroep.nl</a></p>
			<p><strong>Programma's:</strong> Iedere zaterdag van 14.00 tot 16.00 uur</p>
		</div>
		<div class="article-page">
			<h2 class="icon calendar">Activiteiten</h2>
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
	</div>
</div>

<div class="article-area">
	<div class="article-row">
		<div class="article-page">
			<img class="right-into-image" src="img/activiteitengebieden/buitenleven.png" alt="Buitenleven">
			<h2>Bushcraften</h2>
			<p>Als aftrap van het nieuwe Scoutingseizoen organiseert Scouting IJsselgroep op zaterdagmidag 27 augustus een Buscraft Workshop
				voor jongens in de leeftijd van 7 t/m 11 jaar. Maar wat is Bushcraft eigenlijk? Bushcraft is wat anders dan survival; het gaat niet om het overleven,
				maar het gaat om het beleven van de natuur en het jezelf zo aangenaam mogelijk maken! Oftewel een activiteit waar de Scouting zich prima in kan vinden!</p>
			<p>Tijdens het programma wordt er op een primitieve (maar veilige) manier vuur gemaakt en wordt er een simpel maar lekker gerechtje bereid op het kampvuur!
				Daarnaast is er ook nog tijd om een gaaf bosspel te doen.</p>
			<a class="continue" href="#">Lees verder</a>
		</div>
		<div class="article-page">
			<img class="right-into-image" src="img/activiteitengebieden/sport-spel.png" alt="Sport en spel">
			<h2>Vriendjesmiddag groot succes!</h2>
			<p>Afgelopen zaterdagmiddag werd er bij de Scouting in Gorssel een vriendjes- en vriendinnetjesmiddag gehouden.
				Dat er veel interesse is in de Scouting bleek wel uit het grote aantal kinderen die meededen met het programma, in totaal waren er ruim 40 jongens en meisjes!</p>
			<p>De middag begon met de offici&euml;le opening met het hjisen van de vlag. Hierna werd er in het bos een gaaf teamspel gedaan, namelijk levend stratego!
				Er werd lekker fanatiek meegedaan door alle kinderen waardoor de tijd vloog!
				Na het drinken van warme chocolademelk in de kampvuurkuil werd de groep opgesplitst in twee&euml;n.
				De ene helft mocht een broodje bakken bij het kampvuur en de andere helft ging levend kwartet spelen!</p>
			<a class="continue" href="#">Lees verder</a>
		</div>
	</div>
</div>

@endsection