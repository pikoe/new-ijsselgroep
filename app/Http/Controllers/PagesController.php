<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Page;

class PagesController extends Controller {
	public function index(Request $request) {
		return view('pages.index', [
			'pages' => Page::get()->toTree()
		]);
	}
	public function add(Request $request) {
		if($request->isMethod('post')) {
			$page = new Page($request->all());
			$page->save();
		}
		return view('pages.add', [
			'page' => new Page
		]);
	}
	public function edit(Request $request, Page $page) {
		
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
}
