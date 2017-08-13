<?php namespace App\Models;

class Group extends Model {
	protected $fillable = [
		'name'
	];
	
	public function page() {
		return $this->belongsTo(Page::class);
	}
}
