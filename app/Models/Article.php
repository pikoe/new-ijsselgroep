<?php namespace App\Models;

class Article extends Model {
	protected $fillable = [
		'title',
		'url',
		'intro',
		'text'
	];
}
