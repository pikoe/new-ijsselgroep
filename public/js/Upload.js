var Upload = new Class({

	Implements: [Options, Events, Class.Singleton],

	Binds: [
		'sendChunk',
		'progressChunk',
		'responseChunk'
	],
	
	options: {
		chunkSize: 25000, // 1024 * 1024 // 1MB chunk sizes.
		progress: Function.from(true),
		ready: Function.from(true)
	},
	
	errors: 0,
	
	start: 0,
	end: null,
	tmpId: null,
	
	initialize: function(file, target, token, options){
		this.setOptions(options);
		
		this.file = file;
		this.target = target;
		this.token = token;
		this.tmpId = String.uniqueID();
		
		this.end = Math.min(this.options.chunkSize, this.file.size);
		
		this.sendChunk();
		
		return this;
	},
	
	sendChunk: function() {
		this.xhr = new XMLHttpRequest();
		this.xhr.open('POST', this.target, true);
		this.xhr.setRequestHeader('X-CSRF-TOKEN', this.token);
		this.xhr.setRequestHeader('X-Bites-total', this.file.size);
		this.xhr.setRequestHeader('X-Bites-start', this.start);
		this.xhr.setRequestHeader('X-Bites-end', this.end);
		this.xhr.setRequestHeader('X-tmp-id', this.tmpId);
		
		this.xhr.onreadystatechange = this.responseChunk;
		this.xhr.upload.addEventListener('progress', this.progressChunk);
		
		this.xhr.send(this.file.slice(this.start, this.end));
	},
	progressChunk: function(e) {
		if (e.lengthComputable) {
			this.options.progress.apply(this, [(this.start + e.loaded) / this.file.size]);
		}
	},
	responseChunk: function() {
		if(this.xhr.readyState == 4) {
			this.options.progress.apply(this, [this.end / this.file.size]);
			if(this.xhr.status == 200) {
				this.errors = 0;
				if(this.end < this.file.size) {
					this.start = this.end;
					this.end = Math.min(this.end + this.options.chunkSize, this.file.size);
					this.sendChunk();
				} else {
					this.options.ready.apply(this);
				}
			} else if(this.xhr.status == 500 && this.errors < 3) {
				this.errors++;
				this.sendChunk();
			} else if(this.xhr.responseText) {
				console.log(this.xhr.responseText);
			} else {
				console.log('upload error');
			}
		}
	}
});
