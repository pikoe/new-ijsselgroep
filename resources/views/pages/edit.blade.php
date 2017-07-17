@extends('layouts.admin')

@section('crumbs')
<a href="{{ route('pages.index') }}">Pagina's</a>
<a href="{{ route('pages.edit', [$page->id]) }}">{{ $page->name }}</a>
@endsection

@section('content')
<form class="form" action="{{ route('pages.edit', [$page->id]) }}" method="POST">
	<div class="toolbar clearfix">
		<input type="hidden" name="_token" value="{{ csrf_token() }}">
		<h2>Pagina bewerken</h2>
		<div class="buttons">
			<a id="delete-page" class="button delete" href="{{ route('pages.delete', $page->id) }}"><i class="fa fa-trash-o" aria-hidden="true"></i> Verwijderen</a>
		</div>
	</div>
	
	<div class="input">
		<label for="title">Menu titel</label>
		<input name="title" id="title" value="{{ old('title', $page->title) }}" size="45" required>
	</div>
	<div class="input">
		<label for="sub_title">Ondertitel</label>
		<input name="sub_title" id="sub_title" value="{{ old('sub_title', $page->sub_title) }}" size="45" required>
	</div>
	<div class="input">
		<label for="name">Pagina naam</label>
		<input name="name" id="name" value="{{ old('name', $page->name) }}" size="45" required>
	</div>
	<div class="input">
		<label for="url">Pagina url</label>
		<input name="url" id="url" value="{{ old('url', $page->url) }}" size="45" required pattern="[a-z0-9\-]+" data-pattern-msg="Gebruik alleen kleine letters, cijfers of koppelstreepjes">
	</div>
	
	<div class="input">
		<label for="layout">Layout</label>
		<select name="layout" id="layout" required>
			@foreach($layouts as $layout)
			<option{{ (old('layout', $page->layout) == $layout ? ' selected' : '') }}>{{ $layout }}</option>
			@endforeach
		</select>
	</div>
	
	<div class="toolbar clearfix">
		<div class="buttons bottom">
			<button class="button add" title="Bewerken"><i class="fa fa-cogs" aria-hidden="true"></i> Opslaan</button>
			<a class="button" href="{{ route('pages.index') }}"><i class="fa fa-times" aria-hidden="true"></i> Terug</a>
		</div>
	</div>
</form>

<div id="content-editor">
	<div class="toolbar clearfix">
		<input type="hidden" name="_token" value="{{ csrf_token() }}">
		<h2>Pagina inhoud</h2>
		<div class="buttons">
			<a id="add-page-block" class="button add" href="#"><i class="fa fa-plus" aria-hidden="true"></i> Onderdeel toevoegen</a>
		</div>
	</div>
	
	@if(in_array(old('layout', $page->layout), $layouts))
	@include('page-layouts/' . old('layout', $page->layout))
	@else
	<div class="form">Layout niet gevonden</div>
	@endif
</div>

<div id="new-blocks">
	<h2>Sleep &eacute;&eacute;n van onderstaande onderdelen naar de plek waar je hem wil hebben</h2>
	<div id="new-page-blocks">
		@foreach($contentModels as $contentModel)
			<div data-model="{{ $contentModel }}" class="block new-block">{{ trans('content-model.' . $contentModel) }}</div>
		@endforeach
	</div>
</div>
<div id="edit-blocks">
	<a id="edit-page-block" class="button add" href="{{ route('pagecontents.edit', ['content_id']) }}"><i class="fa fa-cogs" aria-hidden="true"></i></a>
	<a id="delete-page-block" class="button delete" href="{{ route('pagecontents.delete', ['content_id']) }}"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
</div>
<div id="content-editor-freeze"><i class="fa fa-cog fa-spin fa-3x fa-fw"></i></div>

@endsection

@section('javascript')
<script type="text/javascript">
	document.id('delete-page').addEvent('click', function(e) {
		e.preventDefault();
		e.currentTarget = this;
		new Confirm('Wilt u deze pagina en eventuele subpaginas verwijderen?', function() {
			new Request({
				url: e.currentTarget.href,
				data: {
					_token: '{{ csrf_token() }}'
				},
				onSuccess: function() {
					location.href = '{{ route('pages.index') }}';
				}
			}).post();
		}, function() {});
	});
	document.id('name').addEvent('keyup', function() {
		document.id('url').value = this.value.toLowerCase().replace(/[^0-9a-z]+/g, '-');
	});
	
	var newBlocks = document.id('new-blocks').setStyle('display', 'none');
	var addButton = document.id('add-page-block');
	
	addButton.addEvent('click', function(e) {
		e.preventDefault();
		
		if(newBlocks.getStyle('display') == 'none') {
			newBlocks.setStyles({
				display: '',
				top: Math.max(document.getElement('#content-editor .toolbar').getPosition(document.id('wrapper')).y + 27, window.getScroll().y + 15)
			});
		} else {
			newBlocks.setStyle('display', 'none');
		}
	});
	
	function resize() {
		newBlocks.setStyles({
			top: Math.max(document.getElement('#content-editor .toolbar').getPosition(document.id('wrapper')).y + 27, window.getScroll().y + 15)
		});
		addButton.setStyles({
			top: Math.max(document.getElement('#content-editor .toolbar').getPosition(document.id('wrapper')).y, window.getScroll().y + 15)
		});
		document.id('content-editor-freeze').setStyles({
			height: document.id('wrapper').getSize().y - document.getElement('#content-editor .toolbar').getPosition(document.id('wrapper')).y,
			top: document.getElement('#content-editor .toolbar').getPosition(document.id('wrapper')).y,
		});
	}
	document.id('content-editor-freeze').setStyles({
		opacity: 0.5,
		display: 'none'
	});
	window.addEvent('resize:throttle(200)', resize);
	window.addEvent('scroll', resize);
	resize();
	
	var editBlocks = document.id('edit-blocks').setStyle('display', 'none');
	document.id('content-editor').addEvent('mouseleave:relay(.page-block .content-block)', function(e) {
		editBlocks.setStyle('display', 'none');
	}).addEvent('mouseenter:relay(.page-block .content-block)', function(e) {
		if(this.id) {
			editBlocks.inject(this).setStyle('display', '');
		}
	});
	document.id('edit-page-block').addEvent('click', function(e) {
		e.preventDefault();
		location.href = this.href.replace('content_id', this.getParent('.content-block').id.replace('content-', ''));
	});
	document.id('delete-page-block').addEvent('click', function(e) {
		e.preventDefault();
		var block = this.getParent('.content-block');
		var url = this.href.replace('content_id', block.id.replace('content-', ''));
		new Confirm('Wilt u dit onderdeel verwijderen?', function() {
			new Request({
				url: url,
				data: {
					_token: '{{ csrf_token() }}'
				},
				onSuccess: function() {
					block.dispose();
				}
			}).post();
		}, function() {});
	});
	
	var blockSort = new Sortables('.page-block', {
		clone: false,
		revert: true,
		opacity: 0.7,
		onStart(el) {
			if(el.getParent('#new-page-blocks')) {
				blockSort.addItems(el.clone().setStyle('opacity', 1).inject(el, 'after'));
				document.id('new-blocks').setStyle('display', 'none');
			}
		},
		onComplete() {
			document.id('content-editor-freeze').setStyle('display', 'block');
			
			var post = {};
			this.serialize(false, function(el, i) {
				post['block[' + el.getParent('.page-block').getProperty('data-block') + '][' + i + ']'] = el.id ? el.id.replace('content-', '') : el.getProperty('data-model');
			})
			
			new Request({
				url: '{{ route('pagecontents.drop', [$page->id]) }}',
				headers: {
					'X-CSRF-TOKEN': '{{ csrf_token() }}'
				},
				onSuccess: function(response){
					var newBlock = document.getElement('.page-block .block.new-block');
					if(newBlock) {
						var tmpHolder = new Element('div', {
							html: response
						});
						var newContent = tmpHolder.getElement('div').replaces(newBlock);
						blockSort.addItems(newContent);
					}
					document.id('content-editor-freeze').setStyle('display', 'none');
				}
			}).post(post);
			
		}
	}).addItems(
		document.getElements('#new-page-blocks .block')
	);
</script>
@endsection
