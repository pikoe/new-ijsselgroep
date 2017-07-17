<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use App\Models\Page;
use App\Models\PageContent;

class PageContentsController extends Controller {
	public function drop(Request $request, Page $page) {
		$newContent = '0';
		foreach($request->block as $block => $blockcontent) {
			foreach($blockcontent as $prio => $content) {
				if(in_array($content, PageContent::$contentModels)) {
					$class = 'App\\Models\\Content\\' . $content;
					$instance = $class::createDefault($page->id, $block);
					
					$pageContent = new PageContent;
					$pageContent->model_id = $instance->id;
					$pageContent->model = $content;
					$pageContent->page_id = $page->id;
					$pageContent->block = $block;
					$pageContent->prio = $prio;
					$pageContent->save();
					$newContent = $pageContent->display();
				} else if(is_numeric($content)) {
					$pageContent = PageContent::find($content);
					$pageContent->page_id = $page->id;
					$pageContent->block = $block;
					$pageContent->prio = $prio;
					$pageContent->save();
				}
			}
		}
		return $newContent;
	}
	
	public function edit(Request $request, PageContent $pageContent) {
		if($request->isMethod('post')) {
			return $pageContent->saveEdit($request);
		}
		
		View::share('key', 'value');
		
		return $pageContent->displayEdit();
	}
	
	public function delete(Request $request, PageContent $pageContent) {
		PageContent::where('page_id', '=', $pageContent->page_id)
			->where('block', '=', $pageContent->block)
			->where('prio', '>', $pageContent->prio)
			->decrement('prio');
		return [(bool)$pageContent->delete()];
	}
}
