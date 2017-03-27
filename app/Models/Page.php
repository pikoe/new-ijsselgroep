<?php namespace App\Models;

use Kalnoy\Nestedset\NodeTrait;

class Page extends Model {
	use NodeTrait;
	
	protected $fillable = [
		'name',
		'url'
	];


	public function getLftName() {
		return 'lft';
	}

	public function getRgtName() {
		return 'rgt';
	}

	public function getParentIdName() {
		return 'parent_page_id';
	}

	// Specify parent id attribute mutator
	public function setParentAttribute($value) {
		$this->setParentPageIdAttribute($value);
	}
}
