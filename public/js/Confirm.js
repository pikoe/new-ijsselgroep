var Confirm = new Class({

	Implements: [Options, Events, Class.Singleton],

	Binds: [
		'detach',
		'keyup',
		'clickConfirm',
		'clickDecline'
	],

	initialize: function(question, confirm, decline){
		this.question = question;
		this.confirm = confirm;
		this.decline = decline;
		
		
		this.box = new Element('div.confirm', {
			html: question
		});
		this.overlay = new Element('div.overlay');
		
		new Element('a.button.add', {
			html: '<i class="fa fa-check" aria-hidden="true"></i> Okay'
		}).inject(this.box).addEvent('click', this.clickConfirm);
		new Element('a.button.cancel', {
			html: '<i class="fa fa-reply" aria-hidden="true"></i> Grapje'
		}).inject(this.box).addEvent('click', this.clickDecline);
		
		this.box.inject(this.overlay);
		this.overlay.inject(document.body);
		document.addEvent('keyup', this.keyup);
		
		return this;
	},
	
	keyup: function(event) {
		switch(event.key) {
			case 'esc':
			case 'backspace':
				this.detach(false);
				break;
			case 'enter':
			case 'space':
				this.detach(true);
				break;
		}
		return this;
	},
	
	clickConfirm: function(){
		this.detach(true);
	},
	
	clickDecline: function(){
		this.detach(false);
	},

	detach: function(confirm){
		this.overlay.dispose();
		document.removeEvent('keyup', this.keyup);
		
		if(confirm) {
			this.confirm();
		} else {
			this.decline();
		}
		return this;
	}
});
