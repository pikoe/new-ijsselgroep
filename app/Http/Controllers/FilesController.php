<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FilesController extends Controller {
	public function editor_upload(Request $request) {
		$filename = preg_replace('/blobid\d{13}_/', '', $request->file->getClientOriginalName());
		$prefix = '';
		if(file_exists(public_path('upload/' . $filename))) {
			$prefix = 1;
			while(file_exists(public_path('upload/' . $prefix . '_' . $filename))) {
				$prefix++;
			}
			$prefix .= '_';
		}
		$request->file->move(public_path('upload'), $prefix . $filename);
		
		return ['location' => 'upload/' . $prefix . $filename];
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
