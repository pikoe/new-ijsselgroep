<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Page;

class PagesController extends Controller {
	public function index(Request $request) {
		return view('pages.index', [
			'pages' => Page::orderBy('pages.lft')->get()->toTree()
		]);
	}
	public function add(Request $request) {
		if($request->isMethod('post')) {
			$page = new Page($request->all());
			$page->full_url = $request->url;
			if($page->save()) {
				return redirect()->route('pages.index');
			}
		}
		return view('pages.add', [
			'page' => new Page
		]);
	}
	public function edit(Request $request, Page $page) {
		if($request->isMethod('post')) {
			$page->fill($request->all());
			if($page->save()) {
				return redirect()->route('pages.index');
			}
		}
		return view('pages.edit', [
			'page' => $page
		]);
	}
	public function delete(Page $page) {
		if($page->delete()) {
			return [true];
		} else {
			return [false];
		}
	}
	public function reorder(Request $request) {
		$tree = $request->tree;
		array_walk_recursive($tree, function(&$id) {
			if(is_numeric($id)) {
				$id = (int)$id;
			} else if(empty($id) || $id == 'false') {
				$id = [];
			} else {
				throw new \Exception('Invalid tree data');
			}
		});
		
		if(Page::rebuildTree($tree)) {
			return [Page::setFullNames(Page::orderBy('pages.lft')->select('id', 'parent_page_id', 'lft', 'rgt', 'url')->get()->toTree())];
		} else {
			return [false];
		}
	}

	public function editor_images() {
		$directory = new \RecursiveDirectoryIterator(public_path('upload'));
		$files = [];
		foreach($directory as $file) {
			if($file->isFile()) {
				$files[] = [
					'title' => $file->getBasename('.'.$file->getExtension()),
					'value' => 'upload/' . $file->getFilename()
				];
			}
		}
		return $files;
	}
	
	public function display(Page $page) {
		return view('layouts.display', [
			'page' => $page
		]);
	}
}
