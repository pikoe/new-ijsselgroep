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
	
	<link rel="stylesheet" type="text/css" media="screen" href="css/admin.css">
</head>
<body>
	<nav id="menu">
		<div class="user-img">
			<img class="gravatar" src="https://www.gravatar.com/avatar/<?= md5('dennis_veeneman@hotmail.com') ?>?d=mm" alt="gravatar dennis_veeneman@hotmail.com">
		</div>
		<ul>
			<li>
				<a class="calendar" href="calendar">Kalender</a>
			</li>
			<li>
				<a class="settings" href="#">Settings</a>
				<ul>
					<li>
						<a href="#">Link 2.1</a>
					</li>
					<li>
						<a href="#">Link 2.2</a>
					</li>
					<li>
						<a href="#">Link 2.2</a>
					</li>
				</ul>
			</li>
			<li>
				<a class="users" href="#">Leden</a>
				<ul>
					<li>
						<a href="#">Link 3.1</a>
					</li>
					<li>
						<a href="#">Link 3.2</a>
					</li>
					<li>
						<a href="#">Link 3.2</a>
					</li>
				</ul>
			</li>
			<li>
				<a class="map" href="#">Kaart</a>
			</li>
		</ul>
	</nav>
	<div id="wrapper">
		<div id="top">
			<div id="menu-toggle"><i></i></div>
		</div>
		<header>
			<h1>Pikoe.nl Admin</h1>
		</header>
		<?= str_repeat('Content 123<br>', 1000) ?>
	</div>
	<script type="text/javascript" src="js/MooTools-More-1.6.0-compressed.js"></script>
	<script type="text/javascript">
		document.id('menu').addEvents({
			'mouseenter': function() {
				document.body.addClass('menu-open');
			},
			'mouseleave': function() {
				if(!document.body.hasClass('menu-lock')) {
					document.body.removeClass('menu-open');
				}
			}
		});
		document.id('menu-toggle').addEvent('click', function() {
			if(document.body.hasClass('menu-open')) {
				document.body.removeClass('menu-open').removeClass('menu-lock');
			} else {
				document.body.addClass('menu-open').addClass('menu-lock');
			}
		});
	</script>
</body>
</html>