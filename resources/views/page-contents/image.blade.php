@extends('layouts.admin')

@section('crumbs')
<a href="{{ route('pages.index') }}">Pagina's</a>
<a href="{{ route('pages.edit', [$pageContent->page_id]) }}">{{ $pageContent->page->name }}</a>
<a href="{{ route('pagecontents.edit', [$pageContent->id]) }}">{{ $image->title }}</a>
@endsection

@section('content')
<form class="form" id="image-form" action="{{ route('pagecontents.edit', [$pageContent->id]) }}" method="POST">
	<div class="toolbar clearfix">
		<input type="hidden" name="_token" value="{{ csrf_token() }}">
		<h2>Afbeelding bewerken</h2>
	</div>
	<div class="preview-area">
		<img id="preview" src="{{ $image->src }}" alt="{{ $image->alt }}">
		<input type="file" id="upload">
	</div>
</form>
@endsection


@section('javascript')
<script type="text/javascript">
var holder = document.id('image-form'),
    /*tests = {
      filereader: typeof FileReader != 'undefined',
      dnd: 'draggable' in document.createElement('span'),
      formdata: !!window.FormData,
      progress: "upload" in new XMLHttpRequest
    },*/
    acceptedTypes = {
      'image/png': true,
      'image/jpeg': true,
      'image/gif': true
    },
    fileupload = document.id('upload'),
	preview = document.id('preview');

var progressDiv = new Element('div.progress').inject(preview, 'after').setStyle('display', 'none');
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


function readfiles(file) {
    if (acceptedTypes[file.type] === true) {
		preview.setStyle('opacity', 0.5);
		progressDiv.setStyle('display', 'block');
		var reader = new FileReader();
		reader.onload = function (event) {
			preview.src = event.target.result;
		};
		reader.readAsDataURL(file);

		var formData = new FormData();
		formData.append('_token', '{{ csrf_token() }}');
		formData.append('image', file);

		var xhr = new XMLHttpRequest();
		xhr.open('POST', '{{ route('pagecontents.edit', [$pageContent->id]) }}');
		xhr.onload = function() {
			progress.attr({
				arc: 1
			});
			preview.setStyle('opacity', 1);
			progressDiv.setStyle('display', 'none');
		};
		xhr.upload.onprogress = function (event) {
			if (event.lengthComputable) {
				progress.attr({
					arc: event.loaded / event.total
				});
			}
		};

		xhr.send(formData);
	}
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
	readfiles(e.dataTransfer.files[0]);
};

fileupload.onchange = function () {
	readfiles(this.files[0]);
	this.value = null;
};

</script>
@endsection