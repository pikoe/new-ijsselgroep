@extends('layouts.admin')

@section('crumbs')
<a href="{{ route('articles.index') }}">Artikelen</a>
<a href="{{ route('articles.edit', [$article->id]) }}">{{ $article->title }}</a>
@endsection

@section('content')
<form id="article-form" class="form" action="{{ route('articles.edit', [$article->id]) }}" method="POST">
	<div class="toolbar clearfix">
		<input type="hidden" name="_token" value="{{ csrf_token() }}">
		<h2>Artikel bewerken</h2>
		<div class="buttons">
			<a id="delete-article" class="button delete" href="{{ route('articles.delete', $article->id) }}"><i class="fa fa-trash-o" aria-hidden="true"></i> Verwijderen</a>
		</div>
	</div>
	
	<div class="input">
		<label for="title">Titel</label>
		<input name="title" id="title" value="{{ old('title', $article->title) }}" size="45" required>
	</div>
	<div class="input">
		<label for="url">Artikel url</label>
		<input name="url" id="url" value="{{ old('url', $article->url) }}" size="45" required pattern="[a-z0-9\-]+" data-pattern-msg="Gebruik alleen kleine letters, cijfers of koppelstreepjes">
	</div>
	
	<div class="input">
		<label for="event_id">Activiteit</label>
		<select name="event_id" id="event_id">
			<option value="">Kies een activiteit</option>
			@foreach($events->get() as $event)
			<option value="{{ $event->id }}"{{ ($event->id == old('event_id', $article->event_id) ? ' selected' : '') }}>{{ $event->name }}</option>
			@endforeach
		</select>
	</div>
	<div class="input">
		<label for="activity_area">Activiteitengebied</label>
		<select name="activity_area" id="activity_area">
			<option value="">Kies een activiteitengebied</option>
			@foreach(\App\Models\ActivityArea::$list as $activity_area => $name)
			<option value="{{ $activity_area }}"{{ ($activity_area == old('activity_area', $article->activity_area) ? ' selected' : '') }}>{{ $name }}</option>
			@endforeach
		</select>
	</div>
	<div class="input">
		<label>Groep</label>
		<ul class="radio-list">
			<li>
				<input type="radio" id="group_0" name="group_id" value=""{{ null == old('group_id', $article->group_id)?' checked':'' }}>
				<label for="group_0">Geen</label>
			</li>
		@foreach($groups->get() as $group)
			<li>
				<input type="radio" id="group_{{ $group->id }}" name="group_id" value="{{ $group->id }}"{{ $group->id == old('group_id', $article->group_id)?' checked':'' }}>
				<label for="group_{{ $group->id }}">{{ $group->name }}</label>
			</li>
		@endforeach
		</ul>
	</div>
	<div class="input">
		<label>Locatie</label>
		<ul class="radio-list">
			<li>
				<input type="radio" id="location_0" name="location_id" value=""{{ null == old('location_id', $article->location_id)?' checked':'' }}>
				<label for="location_0">Geen</label>
			</li>
		@foreach($locations->get() as $location)
			<li>
				<input type="radio" id="location_{{ $location->id }}" name="location_id" value="{{ $location->id }}"{{ $location->id == old('location_id', $article->location_id)?' checked':'' }}>
				<label for="location_{{ $location->id }}">{{ $location->name }}</label>
			</li>
		@endforeach
		</ul>
	</div>
	
	<div class="input textarea">
		<label for="intro">Intro</label>
		<textarea class="editor" name="intro">{{ old('intro', $article->intro) }}</textarea>
	</div>
	<div class="input textarea">
		<label for="text">Volledig</label>
		<textarea class="editor" name="text">{{ old('text', $article->text) }}</textarea>
	</div>
	
	<div class="toolbar clearfix">
		<div class="buttons bottom">
			<button class="button add" title="Bewerken" name="return" value="index"><i class="fa fa-reply" aria-hidden="true"></i> Opslaan en terug naar overzicht</button>
			<button class="button add" title="Bewerken"><i class="fa fa-cogs" aria-hidden="true"></i> Opslaan</button>
			<a class="button back" href="{{ route('articles.index') }}"><i class="fa fa-times" aria-hidden="true"></i> Terug</a>
		</div>
	</div>
	
	<div class="images">
		<input type="file" id="upload" class="file_input" multiple>
		<label class="button" for="upload"><i class="fa fa-upload" aria-hidden="true"></i> Upload foto's</label>
		
		<div class="image-list clearfix"></div>
	</div>
	
	<div class="preview-area">
		<img id="preview">
	</div>
</form>
@endsection

@section('javascript')
<script type="text/javascript">
document.id('delete-article').addEvent('click', function(e) {
	e.preventDefault();
	e.currentTarget = this;
	new Confirm('Wilt u dit artikel verwijderen?', function() {
		new Request({
			url: e.currentTarget.href,
			data: {
				_token: '{{ csrf_token() }}'
			},
			onSuccess: function() {
				location.href = '{{ route('articles.index') }}';
			}
		}).post();
	}, function() {});
});
document.id('title').addEvent('keyup', function() {
	document.id('url').value = this.value.toLowerCase().replace(/[^0-9a-z]+/g, '-');
});

var holder = document.id('article-form'),
    fileupload = document.id('upload');

function readfiles(files) {
	Array.each(files, function(file) {
		if(['image/png','image/jpeg','image/gif'].contains(file.type)) {
			var tile = new Element('div.image_tile');
			var image = new Element('img', {
				styles: {
					opacity: 0.5
				}
			}).inject(tile, 'bottom');
			var reader = new FileReader();
			reader.onload = function(event) {
				image.src = event.target.result;
			};
			reader.readAsDataURL(file);
			
			var progressDiv = new Element('div.progress').inject(tile, 'bottom');
			var r = Raphael(progressDiv, 20, 20);
			// Custom Attribute
			r.customAttributes.arc = function (value) {
				var alpha = 360 * value,
					a = (90 - alpha) * Math.PI / 180,
					x = 10 + 7 * Math.cos(a),
					y = 10 - 7 * Math.sin(a),
					path;
				if (value == 1) {
					path = [["M", 10, 3], ["A", 7, 7, 0, 1, 1, 9.999, 3]];
				} else {
					path = [["M", 10, 3], ["A", 7, 7, 0, +(alpha > 180), 1, x, y]];
				}
				return {path: path};
			};
			r.path().attr({
				stroke: "#f3f3f3",
				"stroke-width": 6,
				arc: 1
			});
			var progress = r.path().attr({
				stroke: "#55aaf3",
				"stroke-width": 6,
				arc: 0
			});
			
			new Upload(file, '{{ route('files.upload') }}', '{{ csrf_token() }}', {
				progress: function(part) {
					if(part == 1) {
						progressDiv.fade('out');
						image.fade('in');
					} else {
						progress.attr({
							arc: part
						});
					}
				},
				chunkSize: {{ $maxChunkSize }}
			});
			
			tile.inject(document.getElement('.image-list'), 'bottom');
		}
	});
}

holder.ondragover = function () {
	holder.addClass('hover');
	return false;
};
holder.ondragleave = function () {
	holder.removeClass('hover');
	return false;
};
holder.ondragend = function () {
	holder.removeClass('hover');
	return false;
};
holder.ondragexit = function () {
	holder.removeClass('hover');
	return false;
};
holder.ondrop = function (e) {
	e.preventDefault();
	holder.removeClass('hover');
	readfiles(e.dataTransfer.files);
};

fileupload.onchange = function () {
	readfiles(this.files);
	this.value = null;
};

</script>
@endsection

https://github.com/ZiTAL/html5-file-upload-chunk