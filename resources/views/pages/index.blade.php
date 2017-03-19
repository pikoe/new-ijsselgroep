@extends('layouts.admin')

@section('content')
<div class="form">
	<ul class="tree" id="tree">
		<li data-page-id="1">
			<span>
				Test 1
				<span class="hover">
					<a class="button" href="#"><i class="fa fa-cogs" aria-hidden="true"></i> Bewerken</a>
					<a class="button delete" href="#"><i class="fa fa-trash-o" aria-hidden="true"></i> Verwijderen</a>
				</span>
			</span>
		</li>
		<li><span>Test 2
				<span class="hover">
					<a class="button" href="#"><i class="fa fa-cogs" aria-hidden="true"></i> Bewerken</a>
					<a class="button delete" href="#"><i class="fa fa-trash-o" aria-hidden="true"></i> Verwijderen</a>
				</span></span></li>
		<li><span>Test 3
				<span class="hover">
					<a class="button" href="#"><i class="fa fa-cogs" aria-hidden="true"></i> Bewerken</a>
					<a class="button delete" href="#"><i class="fa fa-trash-o" aria-hidden="true"></i> Verwijderen</a>
				</span></span>
			<ul>
				<li><span>Test 3.1
				<span class="hover">
					<a class="button" href="#"><i class="fa fa-cogs" aria-hidden="true"></i> Bewerken</a>
					<a class="button delete" href="#"><i class="fa fa-trash-o" aria-hidden="true"></i> Verwijderen</a>
				</span></span>
					<ul>
						<li><span>Test 3.1.1
				<span class="hover">
					<a class="button" href="#"><i class="fa fa-cogs" aria-hidden="true"></i> Bewerken</a>
					<a class="button delete" href="#"><i class="fa fa-trash-o" aria-hidden="true"></i> Verwijderen</a>
				</span></span></li>
						<li><span>Test 3.1.2
				<span class="hover">
					<a class="button" href="#"><i class="fa fa-cogs" aria-hidden="true"></i> Bewerken</a>
					<a class="button delete" href="#"><i class="fa fa-trash-o" aria-hidden="true"></i> Verwijderen</a>
				</span></span></li>
					</ul>
				</li>
				<li><span>Test 3.2
				<span class="hover">
					<a class="button" href="#"><i class="fa fa-cogs" aria-hidden="true"></i> Bewerken</a>
					<a class="button delete" href="#"><i class="fa fa-trash-o" aria-hidden="true"></i> Verwijderen</a>
				</span></span></li>
				<li><span>Test 3.3
				<span class="hover">
					<a class="button" href="#"><i class="fa fa-cogs" aria-hidden="true"></i> Bewerken</a>
					<a class="button delete" href="#"><i class="fa fa-trash-o" aria-hidden="true"></i> Verwijderen</a>
				</span></span></li>
				<li><span>Test 3.4
				<span class="hover">
					<a class="button" href="#"><i class="fa fa-cogs" aria-hidden="true"></i> Bewerken</a>
					<a class="button delete" href="#"><i class="fa fa-trash-o" aria-hidden="true"></i> Verwijderen</a>
				</span></span></li>
			</ul>
		</li>
		<li ><span>Test 4
				<span class="hover">
					<a class="button" href="#"><i class="fa fa-cogs" aria-hidden="true"></i> Bewerken</a>
					<a class="button delete" href="#"><i class="fa fa-trash-o" aria-hidden="true"></i> Verwijderen</a>
				</span></span></li>
		<li class="nodrag"><span>Test 5 (You can't drag me!)
				<span class="hover">
					<a class="button" href="#"><i class="fa fa-cogs" aria-hidden="true"></i> Bewerken</a>
					<a class="button delete" href="#"><i class="fa fa-trash-o" aria-hidden="true"></i> Verwijderen</a>
				</span></span></li>
	</ul>

	<a id="addItem" class="go bold" href="#">Add a new item</a>
</div>
@endsection

@section('javascript')
<script type="text/javascript" src="js/Tree.js"></script>
<script type="text/javascript">
	window.addEvent('domready', function(){
		var pagetree = new Tree(document.id('tree'), {
			checkDrag: function(element){
				return !element.hasClass('nodrag');
			},
			onChange: function(el){
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

		var i = 1;
		document.id('addItem').addEvent('click', function(event){
			event.preventDefault();
			new Element('li').adopt(new Element('span[text=New Item #' + (i++) + ']')).inject('tree');
		});
	});
</script>
@endsection
