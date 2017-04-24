<?php namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Page;

class Front {
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle(Request $request, Closure $next, $guard = null) {
		$request->attributes->add(['menu' => Page::orderBy('pages.lft')->select('id', 'title', 'sub_title', 'parent_page_id', 'lft', 'rgt', 'url', 'full_url')->get()->toTree()]);
		return $next($request);
	}
}
