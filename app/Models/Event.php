<?php namespace App\Models;

class Event extends Model {
	protected $fillable = [
		'name',
		'start',
		'end',
		'location_id',
		'group_id'
	];
	
	protected $dates = [
		'start',
		'end',
	];
}
