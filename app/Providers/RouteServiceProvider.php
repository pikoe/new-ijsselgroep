<?php namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider {
	/**
	 * This namespace is applied to your controller routes.
	 *
	 * In addition, it is set as the URL generator's root namespace.
	 *
	 * @var string
	 */
	protected $namespace = 'App\Http\Controllers';

	/**
	 * Define your route model bindings, pattern filters, etc.
	 *
	 * @return void
	 */
	public function boot() {
		parent::boot();
		
		Route::model('user', \App\Models\User::class);
		Route::model('page', \App\Models\Page::class);
		Route::model('event', \App\Models\Event::class);
		Route::model('page_content', \App\Models\PageContent::class);
		
		Route::bind('article_url', function ($value) {
			return \App\Models\Article::where('url', '=', $value)->first();
		});
		Route::bind('full_url', function ($value) {
			return \App\Models\Page::where('full_url', '=', $value)->first();
		});
	}

	/**
	 * Define the routes for the application.
	 *
	 * @return void
	 */
	public function map() {
		Route::middleware('web')
			 ->namespace($this->namespace)
			 ->group(app_path('Http/Routes.php'));
	}
}
