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
	
	public function upload(Request $request) {
		if(!is_dir(storage_path('tmp'))) {
			mkdir(storage_path('tmp'));
			chmod(storage_path('tmp'), 0777);
		}
		
		$target = storage_path('tmp/' . $request->header('X-tmp-id', '-') . '.tmp');
		
		if(($request->header('X-Bites-start', 0) == 0 && file_exists($target)) || ($request->header('X-Bites-start', 0) > 0 && !file_exists($target)) || (file_exists($target) && $request->header('X-Bites-start', 0) != filesize($target))) {
			return response()->json([
				'error' => 'Filesize not matching startsize'
			], 400);
		}
		
		$input = fopen('php://input', 'r');
		$fp = fopen($target, 'a');
		while ($data = fread($input, 1024)) {
			fwrite($fp, $data);
		}
		fclose($fp);
		fclose($input);
		
		chmod($target, 0666);
		clearstatcache();
		if($request->header('X-Bites-end', 0) != filesize($target)) {
			return response()->json([
				'error' => 'Filesize not matching endsize'
			], 400);
		} else if($request->header('X-Bites-end', 0) == $request->header('X-Bites-total', 1)) {
			
		}
		
		return response()->json([
			'tmp-id' => $request->header('X-tmp-id', '-'),
			'bites' => filesize($target)
		], 200);
	}
}
