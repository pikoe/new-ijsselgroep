@extends('layouts.admin')

@section('content')
<div class="form">
	<div class="toolbar clearfix">
		<h2>Pagina&#39;s</h2>
		<div class="buttons">
			<a class="button add" href="{{ route('pages.add') }}"><i class="fa fa-plus" aria-hidden="true"></i> Toevoegen</a>
		</div>
	</div>
	<ul class="tree" id="tree">
		@php
			$traverse = function($pages) use (&$traverse) {
				$nodes = '';
				foreach ($pages as $page) {
					$nodes .= '
					<li data-page-id="' . $page->id . '">
						<span>
							<span class="hover">
								<a class="button" href="' . route('pages.edit', $page->id) . '"><i class="fa fa-cogs" aria-hidden="true"></i> Bewerken</a>
								<a class="button delete" href="' . route('pages.delete', $page->id) . '"><i class="fa fa-trash-o" aria-hidden="true"></i> Verwijderen</a>
							</span>
							<span' . (empty($page->keyname)?' class="move"':'') . '>' . $page->name . ' (' . $page->children->count() . ')</span>
						</span>';
						if($page->children->count() > 0) {
							$nodes .= '<ul>' . $traverse($page->children) . '</ul>';
						}
					$nodes .= '
					</li>';
				}
				return $nodes;
			};
			echo $traverse($pages);
		@endphp
	</ul>
</div>
@endsection

@section('javascript')
<script type="text/javascript">
	new Tree(document.id('tree'), {
		checkDrag: function(element){
			return !element.hasClass('nodrag');
		},
		onChange: function(el) {
			el.setStyle('opacity', 0.5);
			new Request({
				url: '{{ route('pages.reorder') }}',
				data: {
					_token: '{{ csrf_token() }}',
					tree: this.serialize(function(el){
						return el.getProperty('data-page-id');
					})
				},
				onSuccess: function() {
					el.setStyle('opacity', 1);
				}
			}).post();
		}
	});

	document.id('tree').addEvents({
		'click:relay(.button.delete)': function(event){
			event.preventDefault();
			var el = this.getParent('li').setStyle('opacity', 0.5);
			var url = this.href;
			new Confirm('Wilt u deze pagina en eventuele subpaginas verwijderen?', function() {
				new Request({
					url: url,
					data: {
						_token: '{{ csrf_token() }}'
					},
					onSuccess: function() {
						el.dispose();
					}
				}).post();
			}, function() {
				el.setStyle('opacity', 1);
			});
		}
	});
</script>
@endsection
