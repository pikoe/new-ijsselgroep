<div class="page-block" data-block="1">
	@foreach($page->contents(1)->get() as $content)
		{!! $content->display() !!}
	@endforeach
</div>