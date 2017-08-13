<?php namespace App\Models\Content;

use Illuminate\Http\Request;
use App\Models\PageContent;
use App\Models\Group;
use App\Models\Article;

class ArticleSlot extends Model {
	protected $fillable = [
		'type',
		'group_id'
	];
	
	public static $type = array(
		'last' => 'Nieuwste artikel',
		'for_last' => 'E&eacute;n na nieuwste artikel',
		'rand' => 'Willekeurig artikel'
	);
	
	public static function createDefault() {
		$article_slot = new static();
		$article_slot->save();
		return $article_slot;
	}
	
	public function display() {
		switch($this->type) {
			case 'last':
				$article = Article::orderBy('created_at', 'desc');
				break;
			case 'for_last':
				$article = Article::orderBy('created_at', 'desc')->skip(1);
				break;
			default:
			case 'rand':
				$article = Article::inRandomOrder();
				break;
		}
		
		if($this->group_id) {
			$article->where('group_id', '=', $this->group_id);
		}
		
		return view('page-contents-display.article_slot', [
			'article_slot' => $this,
			'article' => $article->first()
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
		$this->fill($request->all());
		return $this->save();
	}
}
