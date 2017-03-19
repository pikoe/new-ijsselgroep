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
		
		<form method="post">
			<textarea class="editor" name="text">Hello, World!</textarea>
		</form>
		
		<?= str_repeat('Content 123<br>', 10) ?>
	</div>
	<script type="text/javascript" src="js/MooTools-More-1.6.0-compressed.js"></script>
	<script type="text/javascript" src="js/tinymce/tinymce.min.js"></script>
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
		
		tinymce.init({
			selector: 'textarea.editor',
			language: 'nl',
			menubar: false,
			plugins: [
				'advlist autolink lists link image imagetools charmap print preview anchor',
				'searchreplace visualblocks code fullscreen',
				'insertdatetime media table contextmenu paste code'
			],
			toolbar: 'undo redo | insert | styleselect | bold italic underline | alignleft aligncenter alignright | bullist numlist outdent indent | table | link image | code',
			image_list: 'admin/editor-images',
			image_title: true,
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
			images_reuse_filename: true,
			file_picker_callback: function(cb, value, meta) {
				var input = document.createElement('input');
				input.setAttribute('type', 'file');
				input.setAttribute('accept', 'image/*');
				input.onchange = function() {
					var file = this.files[0];
					var id = 'blobid' + (new Date()).getTime() + '_' + file.name.toLowerCase().replace(/[^a-z0-9]+/g, '-');
				console.log(id);
					var blobCache = tinymce.activeEditor.editorUpload.blobCache;
					var blobInfo = blobCache.create(id, file);
					blobCache.add(blobInfo);
					cb(blobInfo.blobUri(), { title: file.name });
				};

				input.click();
			},
			imagetools_toolbar: 'editimage imageoptions'
		});
	</script>
</body>
</html>