<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<base href="{{ env('APP_URL', 'http://localhost') }}/">
	
	<meta name="csrf-token" content="{{ csrf_token() }}">

	<title>{{ config('app.name', 'IJsselgroep') }}</title>
	
	<link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
	<link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
	<link rel="manifest" href="/manifest.json">
	<link rel="mask-icon" href="/safari-pinned-tab.svg" color="#0042df">
	<meta name="theme-color" content="#ffffff">

	<link rel="stylesheet" type="text/css" media="screen" href="css/font-awesome.css">
	<link rel="stylesheet" type="text/css" media="screen" href="css/admin.css">
</head>
<body class="{{ isset($_COOKIE['menu-state'])?$_COOKIE['menu-state']:'' }}">
	<nav id="menu">
		<div class="user-img">
			<img class="gravatar" src="https://www.gravatar.com/avatar/{{ md5(Auth::user()->email) }}?d=mm" alt="gravatar {{ Auth::user()->email }}">
		</div>
		<form class="logout" action="{{ url('/logout') }}" method="POST">
			{{ csrf_field() }}
			<button title="Afmelden">Afmelden</button>
		</form>
		<ul>
			<li>
				<a class="articles" href="{{ route('articles.index') }}">Artikelen</a>
				<ul>
					<li>
						<a class="add" href="{{ route('articles.add') }}">Artiekel toevoegen</a>
					</li>
				</ul>
			</li>
			<li>
				<a class="calendar" href="{{ route('events.index') }}">Kalender</a>
				<ul>
					<li>
						<a class="add" href="{{ route('events.add') }}">Activiteit toevoegen</a>
					</li>
				</ul>
			</li>
			<li>
				<a class="pages" href="{{ route('pages.index') }}">Pagina&#39;s</a>
				<ul>
					<li>
						<a class="add" href="{{ route('pages.add') }}">Pagina toevoegen</a>
					</li>
				</ul>
			</li>
			<li>
				<a class="rental" href="#">Verhuur</a>
			</li>
			<li>
				<a class="users" href="#">Leden</a>
			</li>
		</ul>
	</nav>
	<div id="wrapper">
		<div id="top">
			<div id="menu-toggle" title="Menu in- of uitklappen"><i></i></div>
			<div id="server-time" title="Server tijd">{{ \Carbon\Carbon::now()->format('d-m-Y H:i:s') }}</div>
			<div class="crumbs">@yield('crumbs')</div>
		</div>
		<header>
			<h1>IJsselgroep website beheer</h1>
		</header>
		@yield('content')
	</div>
	<script type="text/javascript" src="js/MooTools-More-1.6.0.js"></script>
	<script type="text/javascript" src="js/tinymce/tinymce.min.js"></script>
	<script type="text/javascript" src="js/raphael.js"></script>
	<script type="text/javascript" src="js/Upload.js"></script>
	<script type="text/javascript" src="js/Tree.js"></script>
	<script type="text/javascript" src="js/Confirm.js"></script>
	<script type="text/javascript">
		Locale.use('nl-NL');
		
		document.id('menu').addEvents({
			mouseenter: function() {
				document.body.addClass('menu-open');
				if(!document.body.hasClass('menu-lock')) {
					Cookie.write('menu-state', 'menu-open', {duration: 30});
				}
			},
			mouseleave: function() {
				if(!document.body.hasClass('menu-lock')) {
					document.body.removeClass('menu-open');
					Cookie.dispose('menu-state');
				}
			}
		});
		document.id('menu-toggle').addEvent('click', function() {
			if(document.body.hasClass('menu-open')) {
				document.body.removeClass('menu-open menu-lock');
				Cookie.dispose('menu-state');
			} else {
				document.body.addClass('menu-open menu-lock');
				Cookie.write('menu-state', 'menu-open menu-lock', {duration: 30});
			}
		});
		
		tinymce.init({
			selector: 'textarea.editor',
			language: 'nl',
			menubar: false,
			min_height: 300,
			plugins: [
				'advlist autolink lists link image imagetools charmap print preview anchor',
				'autoresize searchreplace visualblocks code fullscreen',
				'insertdatetime media table contextmenu paste code'
			],
			toolbar: 'undo redo | insert | styleselect | bold italic underline | alignleft aligncenter alignright | bullist numlist outdent indent | table | link image | code',
			image_list: 'admin/editor-images',
			image_title: true,
			autoresize_bottom_margin: 10,
			automatic_uploads: true,
			images_upload_handler: function (blobInfo, success, failure) {
				var xhr = new XMLHttpRequest();
				xhr.open('POST', 'admin/editor-upload');
				xhr.setRequestHeader('X-CSRF-TOKEN', '{{ csrf_token() }}');
				xhr.onload = function() {
					if (xhr.status != 200) {
						failure('HTTP Error: ' + xhr.status);
						return;
					}
					var json = JSON.parse(xhr.responseText);
					if (!json || typeof json.location != 'string') {
						failure('Invalid JSON: ' + xhr.responseText);
						return;
					}
					success(json.location);
				};
				var formData = new FormData();
				formData.append('file', blobInfo.blob(), blobInfo.filename());
				xhr.send(formData);
			},
			file_picker_types: 'image', 
			document_base_url: '{{ env('APP_URL', 'http://localhost') }}/',
			images_reuse_filename: true,
			file_picker_callback: function(callback, value, meta) {
				var input = document.createElement('input');
				input.setAttribute('type', 'file');
				input.setAttribute('accept', 'image/*');
				input.onchange = function() {
					var file = this.files[0];
					var id = 'blobid' + (new Date()).getTime() + '_' + file.name.toLowerCase().replace(/[^a-z0-9]+/g, '-');
					var blobCache = tinymce.activeEditor.editorUpload.blobCache;
					var blobInfo = blobCache.create(id, file);
					blobCache.add(blobInfo);
					callback(blobInfo.blobUri(), { title: file.name });
				};
				input.click();
			},
			imagetools_toolbar: 'editimage imageoptions',
			setup: function(editor) {
				editor.addMenuItem('agegroups', {
					text: 'Speltakteken',
					context: 'insert',
					menu: [
					{
						text: 'Bevers',
						onclick: function() {
							editor.insertContent('<img class="right-into-image" src="img/speltaktekens/bevers.png" alt="Speltakteken bevers">');
						}
					},
					{
						text: 'Welpen',
						onclick: function() {
							editor.insertContent('<img class="right-into-image" src="img/speltaktekens/welpen.png" alt="Speltakteken welpen">');
						}
					},
					{
						text: 'Scouts',
						onclick: function() {
							editor.insertContent('<img class="right-into-image" src="img/speltaktekens/scouts.png" alt="Speltakteken scouts">');
						}
					},
					{
						text: 'Exporers',
						onclick: function() {
							editor.insertContent('<img class="right-into-image" src="img/speltaktekens/exporers.png" alt="Speltakteken exporers">');
						}
					},
					{
						text: 'Roverscouts',
						onclick: function() {
							editor.insertContent('<img class="right-into-image" src="img/speltaktekens/roverscouts.png" alt="Speltakteken roverscouts">');
						}
					}]
				});
				editor.addMenuItem('gameareas', {
					text: 'Activiteitengebieden',
					context: 'insert',
					menu: [
						@foreach(\App\Models\ActivityArea::$list as $activity_area => $name)
						{
							text: '{{ $name }}',
							onclick: function() {
								editor.insertContent('<img class="right-into-image" src="img/activiteitengebieden/{{ $activity_area }}.png" alt="{{ $name }}">');
							}
						},
						@endforeach
					]
				});
			},
		});
		
		Form.Validator.add('pattern', {
			errorMsg: function(input) {
				return input.getProperty('data-pattern-msg') || 'De invoer moet voldoen aan dit patroon: ' + input.pattern;
			},
			test: function(input){
				return input.value.match(new RegExp('^' + input.pattern + '$'));
			}
		});
		document.getElements('form.form').each(function(form) {
			form.getElements('[required]').addClass('required');
			form.getElements('[pattern]').addClass('pattern');
			form.getElements('[size]').each(function(input) {
				input.addClass('maxLength:' + input.size);
			});
			
			new Form.Validator.Inline(form);
			form.setProperty('novalidate', true);
			
		});
		@foreach($errors->all() as $key => $error)
			alert('{{ $error }} {{ $key }}');
		@endforeach
	</script>
	@yield('javascript')
</body>
</html>