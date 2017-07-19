<?php namespace App\Models\Content;

use Illuminate\Http\Request;
use App\Models\PageContent;
use App\Models\Group;

class ArticleSlot extends Model {
	public static function createDefault() {
		$article_slot = new static();
		$article_slot->save();
		return $article_slot;
	}
	
	public function display() {
		
		return view('page-contents-display.article_slot', [
			'article_slot' => $this,
			'article' => null
		]);
	}
	
	public function displayEdit(PageContent $pageContent) {
		return view('page-contents.article_slot')->with([
			'article_slot' => $this,
			'pageContent' => $pageContent,
			
			'groups' => Group::orderBy('id')
		]);
	}
	public function saveEdit(Request $request, PageContent $pageContent) {
		return $this->save();
	}
}
