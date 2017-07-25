<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\Group;
use App\Models\Event;
use App\Models\Location;
use App\Models\Content\Image;
use Carbon\Carbon;

class ArticlesController extends Controller {
	public function index(Request $request) {
		
		return view('articles.index', [
			'articles' => Article::orderBy('created_at', 'desc')->paginate(25)
		]);
	}
	
	public function add(Request $request) {
		if($request->isMethod('post')) {
			$article = new Article;
			$article->fill($request->all());
			if($article->save()) {
				if($request->return == 'index') {
					return redirect()->route('articles.index');
				} else {
					return redirect()->route('articles.edit', [$article->id]);
				}
			}
			
		}
		
		return view('articles.add', [
			'groups' => Group::orderBy('id'),
			'events' => Event::whereBetween('start', [Carbon::now()->subDays(30), Carbon::now()->addDays(50)])->orderBy('start', 'desc'),
			'locations' => Location::orderBy('name')
		]);
	}
	
	public function edit(Request $request, Article $article) {
		if($request->isMethod('post')) {
			$article->fill($request->all());
			if($article->save()) {
				$images = [];
				foreach($request->image_tmp_id as $key => $image_tmp_id) {
					if(!empty($image_tmp_id)) {
						$tmp = storage_path('tmp/' . $image_tmp_id . '.tmp');
						$file_parts = explode('.', strtolower($request->image_file_name[$key]));
						$extension = array_pop($file_parts);
						if(!empty($request->image_descriptions[$key])) {
							$name = substr(str_slug($request->image_descriptions[$key], '-'), 0, 150);
						} else {
							$name = str_slug(implode('-', $file_parts), '-');
						}
						$img = 'upload/' . $name . '.' . $extension;
						$i = 0;
						while(file_exists(public_path($img))) {
							$img = 'upload/' . $name . '-' . ++$i . '.' . $extension;
						}
						rename($tmp, public_path($img));

						$image = new Image;
						$image->src = $img;
					} else {
						$image = Image::find($request->image_id[$key]);
					}
					$image->alt = $request->image_file_name[$key];
					$image->title = $request->image_descriptions[$key];
					$image->save();
					
					$images[$image->id] = [
						'prio' => $key
					];
				}
				$article->images()->sync($images);
				
				if($request->return == 'index') {
					return redirect()->route('articles.index');
				} else {
					return redirect()->route('articles.edit', [$article->id]);
				}
			}
		}
		
	$maxChunkSize = trim(ini_get('post_max_size'));
    switch(strtolower($maxChunkSize[strlen($maxChunkSize)-1])) {
        // The 'G' modifier is available since PHP 5.1.0
        case 'g':
            $maxChunkSize *= 1024;
        case 'm':
            $maxChunkSize *= 1024;
        case 'k':
            $maxChunkSize *= 1024;
    }
	
		
		return view('articles.edit', [
			'article' => $article,
			
			'groups' => Group::orderBy('id'),
			'events' => Event::whereBetween('start', [Carbon::now()->subDays(30), Carbon::now()->addDays(50)])->orWhere('id', $article->event_id)->orderBy('start', 'desc'),
			'locations' => Location::orderBy('name'),
			
			'maxChunkSize' => $maxChunkSize - 500
		]);
	}
	
	public function delete(Article $article) {
		if($article->delete()) {
			return [true];
		} else {
			return [false];
		}
	}
}
