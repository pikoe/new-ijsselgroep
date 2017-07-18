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
}
