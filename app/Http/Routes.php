<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Auth::routes();

Route::get('/pdf', 'RentalController@pdf');

Route::group(['middleware' => 'auth', 'prefix' => 'admin'], function () {
	Route::post('editor-upload', 'FilesController@editor_upload');
	Route::get('editor-images', 'FilesController@editor_images');
	
	
	Route::get('', function () {
		return redirect()->route('articles.index');
	});

	Route::get('pages', ['uses' => 'PagesController@index', 'as' => 'pages.index']);
	Route::any('pages/add', ['uses' => 'PagesController@add', 'as' => 'pages.add']);
	Route::any('pages/edit/{page}', ['uses' => 'PagesController@edit', 'as' => 'pages.edit']);
	Route::post('pages/delete/{page}', ['uses' => 'PagesController@delete', 'as' => 'pages.delete']);
	Route::post('pages/reorder', ['uses' => 'PagesController@reorder', 'as' => 'pages.reorder']);
	
	Route::post('pagecontents/drop/{page}', ['uses' => 'PageContentsController@drop', 'as' => 'pagecontents.drop']);
	Route::any('pagecontents/edit/{page_content}', ['uses' => 'PageContentsController@edit', 'as' => 'pagecontents.edit']);
	Route::post('pagecontents/delete/{page_content}', ['uses' => 'PageContentsController@delete', 'as' => 'pagecontents.delete']);
	
	Route::get('events/{yyyy?}/{mm?}/{dd?}', ['uses' => 'EventsController@index', 'as' => 'events.index'])->where([
		'yyyy' => '[12][0-9]{3}',
		'mm' => '(0[1-9]|1[012])',
		'dd' => '(0[1-9]|[12][0-9]|3[01])'
	]);
	Route::any('events/add/{start?}/{end?}', ['uses' => 'EventsController@add', 'as' => 'events.add'])->where([
		'start' => '[12][0-9]{3}-(0[1-9]|1[012])-(0[1-9]|[12][0-9]|3[01])',
		'end' => '[12][0-9]{3}-(0[1-9]|1[012])-(0[1-9]|[12][0-9]|3[01])'
	]);
	Route::any('events/edit/{event}', ['uses' => 'EventsController@edit', 'as' => 'events.edit']);
	Route::post('events/event/{event}', ['uses' => 'EventsController@delete', 'as' => 'events.delete']);

	Route::get('articles', ['uses' => 'ArticlesController@index', 'as' => 'articles.index']);
	Route::any('articles/add', ['uses' => 'ArticlesController@add', 'as' => 'articles.add']);
	Route::any('articles/edit/{article}', ['uses' => 'ArticlesController@edit', 'as' => 'articles.edit']);
	Route::post('articles/delete/{article}', ['uses' => 'ArticlesController@delete', 'as' => 'articles.delete']);
	
	Route::get('rental', ['uses' => 'RentalController@index', 'as' => 'rental.index']);
});

Route::group(['middleware' => 'front'], function () {
	Route::get('/', ['uses' => 'PagesController@home', 'as' => 'home']);
	
	Route::get('/artikelen', ['uses' => 'PagesController@articles', 'as' => 'articles']);
	Route::get('/artikelen/{article_url}', ['uses' => 'PagesController@article', 'as' => 'article']);
	
	Route::any('{full_url}', ['uses' => 'pagesController@display'])->where('full_url', '.+');
});
