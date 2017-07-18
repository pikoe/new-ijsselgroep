<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;

class ArticlesController extends Controller {
	public function index(Request $request) {
		
		return view('articles.index', [
			'articles' => Article::paginate()
		]);
	}
	
	public function add(Request $request) {
		if($request->isMethod('post')) {
			$article = new Article;
			$article->fill($request->all());
			
			if($article->save()) {
				//$article->locations()->attach((array)$request->locations);
				//$article->groups()->attach((array)$request->groups);
				
				return redirect()->route('articles.index');
			}
			
		}
		
		return view('articles.add', [
		]);
	}
	
	public function edit(Request $request, Article $article) {
		if($request->isMethod('post')) {
			$article->fill($request->all());
			if($article->save()) {
				//$article->locations()->sync((array)$request->locations);
				//$article->groups()->sync((array)$request->groups);
				
				return redirect()->route('articles.index');
			}
		}
		
		return view('articles.edit', [
			'article' => $article
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
