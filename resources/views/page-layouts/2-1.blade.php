<div class="page-area">
	<div class="page-row">
		<div class="page-block" data-block="1">
			@foreach($page->contents(1)->get() as $content)
				{!! $content->display() !!}
			@endforeach
		</div>
		<div class="page-block" data-block="2">
			@foreach($page->contents(2)->get() as $content)
				{!! $content->display() !!}
			@endforeach
		</div>
	</div>
</div>

<div class="page-block" data-block="3">
	@foreach($page->contents(3)->get() as $content)
		{!! $content->display() !!}
	@endforeach
</div>