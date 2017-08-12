<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<base href="{{ env('APP_URL', 'http://localhost') }}/">
	
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') | Scouting IJsselgroep Gorssel</title>
	<meta name="description" content="@yield('description', '')">
	
	<link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
	<link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
	<link rel="manifest" href="/manifest.json">
	<link rel="mask-icon" href="/safari-pinned-tab.svg" color="#0042df">
	<meta name="theme-color" content="#ffffff">

	<link href="https://fonts.googleapis.com/css?family=PT+Sans" rel="stylesheet">
    <link href="js/PhotoSwipe/photoswipe.css?v=4.1.1-1.0.4" rel="stylesheet" />
    <link href="js/PhotoSwipe/default-skin/default-skin.css?v=4.1.1-1.0.4" rel="stylesheet" />
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
				echo $traverse(request()->get('menu'));
			@endphp
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
	
	<div class="pswp" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="pswp__bg"></div>
		<div class="pswp__scroll-wrap">
			<div class="pswp__container">
				<div class="pswp__item"></div>
				<div class="pswp__item"></div>
				<div class="pswp__item"></div>
			</div>
			<div class="pswp__ui pswp__ui--hidden">
				<div class="pswp__top-bar">
					<div class="pswp__counter"></div>
					<button class="pswp__button pswp__button--close" title="Sluiten (Esc)"></button>
					<button class="pswp__button pswp__button--share" title="Deel"></button>
					<button class="pswp__button pswp__button--fs" title="Volledig scherm"></button>
					<button class="pswp__button pswp__button--zoom" title="Zoom in/uit"></button>
					<div class="pswp__preloader">
						<div class="pswp__preloader__icn">
						  <div class="pswp__preloader__cut">
							<div class="pswp__preloader__donut"></div>
						  </div>
						</div>
					</div>
				</div>
				<div class="pswp__share-modal pswp__share-modal--hidden pswp__single-tap">
					<div class="pswp__share-tooltip"></div> 
				</div>
				<button class="pswp__button pswp__button--arrow--left" title="Vorige (&larr;)"></button>
				<button class="pswp__button pswp__button--arrow--right" title="Volgende (&rarr;)"></button>
				<div class="pswp__caption">
					<div class="pswp__caption__center"></div>
				</div>
			</div>
		</div>
	</div>
	
	<script type="text/javascript" src="js/MooTools-More-1.6.0-compressed.js"></script>
	<script type="text/javascript" src="js/Slider.js"></script>
	<script src="js/PhotoSwipe/photoswipe.min.js?v=4.1.1-1.0.4"></script>
	<script src="js/PhotoSwipe/photoswipe-ui-default.min.js?v=4.1.1-1.0.4"></script>
	<script src="js/PhotoSwipe/photoswipe.fromdom.js"></script>
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
		
		initPhotoSwipeFromDOM('.image-gallery');
		
		document.getElements('.content').addEvent('click:relay(.content-block a[data-content-block-href])', function(e) {
			e.preventDefault();
			var block = this.getParent('.content-block');
			new Request({
				url: '{{ url('block') }}' + block.id.replace('content-', '/') + '?' + this.getProperty('data-content-block-href'),
				method: 'get',
				onRequest: function(){
					block.addClass('loading');
				},
				onSuccess: function(response){
					var els = Elements.from(response);
					els[0].replaces(block);
				},
				onFailure: function(){
					block.set('text', 'Sorry, er ging iets fout');
				}
			}).send();
		});
	</script>
	@yield('javascript', '')
</body>
</html>
