<?php namespace App\Models;

class Event extends Model {
	protected $fillable = [
		'name',
		'start',
		'end',
		'location_id',
		'group_id',
		'public_text',
		'private_text'
	];
	
	protected $dates = [
		'start',
		'end',
		'created_at',
		'updated_at'
	];
	
	public function locations() {
		return $this->belongsToMany(Location::class);
	}
	
	public function groups() {
		return $this->belongsToMany(Group::class);
	}
}
