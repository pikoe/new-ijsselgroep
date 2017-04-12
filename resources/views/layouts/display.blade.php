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
			@php
				$traverse = function($pages) use(&$traverse) {
					$nodes = '';
					foreach($pages as $page) {
						if($page->children->count() > 0) {
							$nodes .= '<li class="has-sub ' . $page->url . '"><a class="icon ' . $page->url . '" href="' . $page->full_url . '">' . e($page->title) . ' <em>' . e($page->sub_title) . '</em></a><ul>' . $traverse($page->children) . '</ul></li>';
						} else {
							$nodes .= '<li class="' . $page->url . '"><a class="icon ' . $page->url . '" href="' . $page->full_url . '">' . e($page->title) . ' <em>' . e($page->sub_title) . '</em></a></li>';
						}
					}
					return $nodes;
				};
				echo $traverse($menu);
			@endphp
		</ul>
	</div>
	<div class="content">
		<ul class="breadcrumbs clearfix">
			<li class="home"><a href="/">Home</a></li>
			@foreach($page->getParents() as $parent)
			<li><a href="{{ $parent->full_url }}">{{ $parent->name }}</a></li>
			@endforeach
			<li><a href="{{ $page->full_url }}">{{ $page->name }}</a></li>
		</ul>
		
		
		<div class="article-page">

		</div>
		
		
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
		
		var headerScroll = new Fx.Scroll(document.getElement('.header'));
		document.id('menu-toggle').addEvent('click', function() {
			if(document.body.hasClass('menu-open')) {
				headerScroll.toTop();
				document.body.removeClass('menu-open');
			} else {
				document.body.addClass('menu-open');
			}
		});
		
		new Slider(document.id('header-slideshow'));
	</script>
</body>
</html>