<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<base href="{{ env('APP_URL', 'http://localhost') }}/">
	
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
	<meta name="description" content="">
	
	<link href="https://fonts.googleapis.com/css?family=PT+Sans" rel="stylesheet">
    <link href="css/web.css" rel="stylesheet">
</head>
<body>
	<div class="header">
		<!--<img src="img/scouting-nl-logo.png" alt="Logo">-->
		<div class="banner" id="header-slideshow">
			<a href="#paasvuur" style="background: #000000 url({{ env('APP_URL', 'http://localhost') }}/img/banner-paasvuur.jpg) no-repeat center center / auto 100%;"></a>
			<a href="#wandeling" style="background: #9cc174 url({{ env('APP_URL', 'http://localhost') }}/img/banner-wandeling.jpg) no-repeat center center / auto 100%;"></a>
			<a href="#spel" style="background: #acacac url({{ env('APP_URL', 'http://localhost') }}/img/banner-spel.jpg) no-repeat center center / auto 100%;"></a>
			<a href="#sneeuw" style="background: #a9ab74 url({{ env('APP_URL', 'http://localhost') }}/img/banner-sneeuw.jpg) no-repeat center center / auto 100%;"></a>
			<a href="#kamp-japan" style="background: #7b746e url({{ env('APP_URL', 'http://localhost') }}/img/banner-japan.jpg) no-repeat center center / auto 100%;"></a>
			<a href="#koken" style="background: #116b30 url({{ env('APP_URL', 'http://localhost') }}/img/banner-koken.jpg) no-repeat center center / auto 100%;"></a>
		</div>
		<a class="logo" href=""></a>
		<div id="menu-toggle"><i></i></div>
		<ul id="menu" class="clearfix">
			<li class="has-sub scouting">
				<a class="icon scouting" href="scouting">Scouting <em>Wat is scouting?</em></a>
				<ul>
					<li class="lid-worden">
						<a class="icon lid-worden" href="scouting/lid-worden">Lid worden <em>of eerst een keer kijken</em></a>
					</li>
					<li class="scoutfit">
						<a class="icon scoutfit" href="scouting/scoutfit">Kleding <em>de scoutfit</em></a>
					</li>
				</ul>
			</li>
			<li class="has-sub leeftijdsgroepen">
				<a class="icon leeftijdsgroepen" href="leeftijdsgroepen">Leeftijdsgroepen <em>de speltakken</em></a>
				<ul>
					<li class="welpen">
						<a class="icon welpen" href="leeftijdsgroepen/welpen">Welpen <em>7-11 jaar</em></a>
					</li>
					<li class="scouts">
						<a class="icon scouts" href="leeftijdsgroepen/scouts">Scouts <em>11-15 jaar</em></a>
					</li>
					<li class="explorers">
						<a class="icon explorers" href="leeftijdsgroepen/explorers">Explorers <em>15-18 jaar</em></a>
					</li>
					<li class="roverscouts">
						<a class="icon roverscouts" href="leeftijdsgroepen/roverscouts">Rovers <em>18-21 jaar</em></a>
					</li>
					<li class="leiding-en-bestuur">
						<a class="icon leiding-en-bestuur" href="leeftijdsgroepen/leiding-en-bestuur">Leiding <em>&amp; bestuur</em></a>
					</li>
					<li class="vrienden-van-de-ijsselgroep">
						<a class="icon vrienden-van-de-ijsselgroep" href="leeftijdsgroepen/vrienden-van-de-ijsselgroep">Vrienden <em>oud leden</em></a>
					</li>
				</ul>
			</li>
			<li class="has-sub activiteiten">
				<a class="icon activiteiten" href="activiteiten">Activiteiten <em>wat doen we?</em></a>
				<ul>
					<li class="kalender">
						<a class="icon kalender" href="activiteiten/kalender">Kalender <em>komende activiteiten</em></a>
					</li>
					<li class="fotos">
						<a class="icon fotos" href="activiteiten/fotos">Foto's <em>van de programma's</em></a>
					</li>
				</ul>
			</li>
			<li class="has-sub verhuur">
				<a class="icon verhuur" href="verhuur">Verhuur <em>gebouwen en terrein</em></a>
				<ul>
					<li class="troephuis">
						<a class="icon troephuis" href="verhuur/troephuis">Troephuis <em>voor je (zomer) kamp</em></a>
					</li>
					<li class="hordehol">
						<a class="icon hordehol" href="verhuur/hordehol">Hordehol <em>het zomerhuisje</em></a>
					</li>
				</ul>
			</li>
			<li class="contact">
				<a class="icon contact" href="contact">Contact <em>en locatie</em></a>
			</li>
		</ul>
	</div>
	<div class="content">
@yield('content')
	</div>
	<div class="footer">
		<span class="memberships"><a class="ijsselgroep" href="/" title="Scouting IJsselgroep Gorssel">Scouting IJsselgroep Gorssel</a><a class="scouting-nl" href="https://www.scouting.nl/" target="_blank" title="Scouting Nederland">Scouting Nederland</a><a class="scout" href="https://www.scout.org/" target="_blank" title="World Organization of the Scout Movement">World Organization of the Scout Movement</a><a class="wagggs" href="https://www.wagggs.org/en/" target="_blank" title="World Association of Girl Guides and Girl Scouts">World Association of Girl Guides and Girl Scouts</a></span>
		<span class="legal">Dit is de offici&euml;le website van de vereniging Scouting IJsselgroep. Copyright &copy; 2016 - {{ date('Y') }}</span>
		<span class="social"><a class="fb" href="https://www.facebook.com/ScoutingIJsselgroep/" target="_blank" title="Volg ons op Facebook">Volg ons op Facebook</a><a class="yt" href="https://www.youtube.com/user/IJsselgroep" target="_blank" title="Bekijk onze video's op Youtube">Bekijk onze video's op Youtube</a><a class="ig" href="https://www.instagram.com/ijsselgroep/" target="_blank" title="Volg ons op Instagram">Volg ons op Instagram</a><a class="tw" href="https://twitter.com/scoutingijssel" target="_blank" title="Volg ons op Twitter">Volg ons op Twitter</a></span>
	</div>
	<script type="text/javascript" src="js/MooTools-More-1.6.0-compressed.js"></script>
	<script type="text/javascript" src="js/Slider.js"></script>
	<script>
		window.addEvent('scroll:pause(100)', function() {
			if(window.getScroll().y) {
				document.body.addClass('scrolled');
			} else {
				document.body.removeClass('scrolled');
			}
		});
		
		document.id('menu-toggle').addEvent('click', function() {
			if(document.body.hasClass('menu-open')) {
				document.body.removeClass('menu-open');
			} else {
				document.body.addClass('menu-open');
			}
		});
		
		new Slider(document.id('header-slideshow'));
	</script>
</body>
</html>
