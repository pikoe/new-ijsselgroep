<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\Group;
use App\Models\Event;
use App\Models\Location;
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
				if($request->return == 'index') {
					return redirect()->route('articles.index');
				} else {
					return redirect()->route('articles.edit', [$article->id]);
				}
			}
		}
		
		return view('articles.edit', [
			'article' => $article,
			
			'groups' => Group::orderBy('id'),
			'events' => Event::whereBetween('start', [Carbon::now()->subDays(30), Carbon::now()->addDays(50)])->orWhere('id', $article->event_id)->orderBy('start', 'desc'),
			'locations' => Location::orderBy('name')
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
