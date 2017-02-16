<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<base href="{{ env('APP_URL', 'http://localhost') }}/ijsselgroep/">
	
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
	<link href="https://fonts.googleapis.com/css?family=PT+Sans" rel="stylesheet">
    <link href="css/app.css" rel="stylesheet">

    <!-- Scripts -->
    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
    </script>
</head>
<body class="menu-open">
	<div class="header">
		<!--<img src="img/scouting-nl-logo.png" alt="Logo">-->
		<img src="img/ijsselgroep-logo.png" alt="Logo">
		<ul class="clearfix">
			<li class="has-sub age-groups">
				<a class="icon age-groups" href="leeftijdsgroepen">Leeftijdsgroepen <em>speltakken</em></a>
				<ul>
					<li><a href="leeftijdsgroepen/welpen">Welpen <em>7-11 jaar</em></a></li>
					<li><a href="leeftijdsgroepen/scouts">Scouts <em>11-15 jaar</em></a></li>
					<li><a href="leeftijdsgroepen/explorers">Explorers <em>16-18 jaar</em></a>
					<li><a href="leeftijdsgroepen/roverscouts">Rovers <em>18-21 jaar</em></a>
					<li><a href="leiding-en-bestuur">Leiding <em>&amp; bestuur</em></a>
					<li><a href="vrienden-van-de-ijsselgroep">Vrienden <em>oud leden</em></a></li>
				</ul>
			</li>
			
			<li class="menu has-sub">
				<a class="icon scouting" href="scouting">Scouting <em>wat is scouting?</em></a>
				<ul>
					<li><a href="lid-worden">Lid worden <em>of eerst eens kijken</em></a></li>
					<li><a href="kleding">Kleding <em>de scoutfit</em></a></li>
				</ul>
			</li>
			
			<li class="menu has-sub">
				<a class="icon activities" href="activiteiten">Activiteiten <em>wat doen we?</em></a>
				<ul>
					<li><a href="kalender">Kalender <em>komende activiteiten</em></a></li>
					<li><a href="fotos">Foto&#39;s <em>van de programma&#39;s</em></a></li>
				</ul>
			</li>
			
			<li class="menu has-sub">
				<a class="icon campsite" href="verhuur">Verhuur <em>gebouwen en terrein</em></a>
				<ul>
					<li><a href="verhuur/troephuis">Troephuis <em>voor je (zomer)kamp</em></a></li>
					<li><a href="verhuur/hordehol">Hordehol <em>het vakantiehuisje</em></a></li>
				</ul>
			</li>
			
			<li class="menu">
				<a class="icon contact" href="contact">Contact <em>en locatie</em></a>
			</li>
		</ul>
	</div>
	<div class="content">
		<h1>Scouting IJsselgroep Gorssel</h1>
		<h2>Jongens scoutinggroep in Gorssel</h2>
		<h3>Al meer dan 70 jaar</h3>
		<?= str_repeat('Content 123<br>', 1000) ?>
	</div>
	<div class="footer">
		<span class="legal">Dit is de offici&euml;le website van de vereniging Scouting IJsselgroep. Copyright &copy; 2016 - {{ date('Y') }}</span>
		<span class="memberships">
			<a class="ijsselgroep" href="/" title="Scouting IJsselgroep Gorssel">Scouting IJsselgroep Gorssel</a>
			<a class="scouting-nl" href="https://www.scouting.nl/" target="_blank" title="Scouting Nederland">Scouting Nederland</a>
			<a class="scout" href="https://www.scout.org/" target="_blank" title="World Organization of the Scout Movement">World Organization of the Scout Movement</a>
			<a class="wagggs" href="https://www.wagggs.org/en/" target="_blank" title="World Association of Girl Guides and Girl Scouts">World Association of Girl Guides and Girl Scouts</a>
		</span>
		<span class="social">
			<a class="fb" href="https://www.facebook.com/ScoutingIJsselgroep/" target="_blank" title="Volg ons op Facebook">Volg ons op Facebook</a>
			<a class="yt" href="https://www.youtube.com/user/IJsselgroep" target="_blank" title="Bekijk onze video's op Youtube">Bekijk onze video's op Youtube</a>
			<a class="ig" href="https://www.instagram.com/ijsselgroep/" target="_blank" title="Volg ons op Instagram">Volg ons op Instagram</a>
			<a class="tw" href="https://twitter.com/scoutingijssel" target="_blank" title="Volg ons op Twitter">Volg ons op Twitter</a>
		</span>
	</div>
	<script type="text/javascript" src="js/MooTools-More-1.6.0-compressed.js"></script>
	<script>
		window.addEvent('scroll:pause(100)', function() {
			if(window.getScroll().y) {
				document.body.addClass('scrolled');
			} else {
				document.body.removeClass('scrolled');
			}
		});
	</script>
</body>
</html>
