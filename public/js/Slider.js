var Slider = new Class({
	el: null,
	slides: [],
	currentIndex: 0,
    initialize: function(el){
        this.el = el;
		this.slides = el.getChildren();
		
		this.currentIndex = Number.random(0, this.slides.length - 1);
		this.slides.some(function(slide, index) {
			slide.inject(this.el);
			if(index === this.currentIndex) {
				return true;
			}
		}, this);
		
		this.next.periodical(5000, this);
    },
	next: function() {
		if(++this.currentIndex === this.slides.length) {
			this.currentIndex = 0;
		}
		this.slides[this.currentIndex].setStyle('opacity', 0).inject(this.el).fade('in');
	}
});