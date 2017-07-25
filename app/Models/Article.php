<?php namespace App\Models;

class Article extends Model {
	protected $fillable = [
		'title',
		'url',
		'intro',
		'text',
		'activity_area',
		
		'group_id',
		'event_id',
		'location_id'
	];
	
	public function images() {
		return $this->belongsToMany(Content\Image::class)->orderBy('article_image.prio');
	}
}
