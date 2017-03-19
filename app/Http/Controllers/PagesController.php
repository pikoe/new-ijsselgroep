<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PagesController extends Controller {
	public function index(Request $request) {
		return view('pages.index');
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
