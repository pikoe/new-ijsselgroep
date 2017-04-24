<?php namespace App\Models;

use Kalnoy\Nestedset\NodeTrait;

class Page extends Model {
	use NodeTrait;
	
	protected $fillable = [
		'title',
		'sub_title',
		'name',
		'url',
		'text'
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
	
	public function getParents() {
		$parents = [];
		$parent = $this->parent;
		if($parent) {
			$parents[] = $parent;
			while($parent = $parent->parent) {
				array_unshift($parents, $parent);
			}
		}
		return $parents;
	}
	
	public static function setFullNames($children = null, $base = false) {
		foreach($children as $page) {
			$page->full_url = ($base ? $base . '/' : '') . $page->url;
			if(!$page->save() || ($page->children && !self::setFullNames($page->children, $page->full_url))) {
				return false;
			}
		}
		return true;
	}
}
