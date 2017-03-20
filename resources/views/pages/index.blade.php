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
						<span>' . $page->name . ' (' . $page->children->count() . ')
							<span class="hover">
								<a class="button" href="#"><i class="fa fa-cogs" aria-hidden="true"></i> Bewerken</a>
								<a class="button delete" href="#"><i class="fa fa-trash-o" aria-hidden="true"></i> Verwijderen</a>
							</span>
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
		<li class="nodrag">
			<span>Test 5 (You can't drag me!)
				<span class="hover">
					<a class="button" href="#"><i class="fa fa-cogs" aria-hidden="true"></i> Bewerken</a>
					<a class="button delete" href="#"><i class="fa fa-trash-o" aria-hidden="true"></i> Verwijderen</a>
				</span>
			</span>
		</li>
	</ul>
</div>
@endsection

@section('javascript')
<script type="text/javascript" src="js/Tree.js"></script>
<script type="text/javascript">
	window.addEvent('domready', function(){
		new Tree(document.id('tree'), {
			checkDrag: function(element){
				return !element.hasClass('nodrag');
			},
			onChange: function(){
				console.log(this.serialize(function(el){
					return el.getProperty('data-page-id');
				}));
			}
		});

		document.id('tree').addEvents({
			'click:relay(.button.delete)': function(event){
				event.preventDefault();
				this.getParent('li').dispose();
			}
		});

		/*var i = 1;
		document.id('addItem').addEvent('click', function(event){
			event.preventDefault();
			new Element('li').adopt(new Element('span[text=New Item #' + (i++) + ']')).inject('tree');
		});*/
	});
</script>
@endsection
