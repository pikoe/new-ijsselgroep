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

Route::get('/home', 'HomeController@index');
Route::get('/pdf', 'RentalController@pdf');
Route::get('/activiteiten/kalender/{yyyy?}/{mm?}/{dd?}', 'CalendarController@activeties')->where([
	'yyyy' => '[12][0-9]{3}',
	'mm' => '(0[1-9]|1[012])',
	'dd' => '(0[1-9]|[12][0-9]|3[01])'
]);

Route::group(['middleware' => 'auth', 'prefix' => 'admin'], function () {
	Route::post('editor-upload', 'FilesController@editor_upload');
	Route::get('editor-images', 'FilesController@editor_images');
	
	
	Route::get('', function () {
		return view('admin');
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
	Route::post('pages/event/{event}', ['uses' => 'EventsController@delete', 'as' => 'events.delete']);
});

Route::group(['middleware' => 'front'], function () {
	Route::get('/article', function () {
		return view('article');
	});
	Route::get('/leeftijdsgroepen/welpen', 'AgeGroupsController@welpen');

	Route::get('/', function () {
		return view('welcome');
	});
	Route::any('{full_url}', ['uses' => 'pagesController@display'])->where('full_url', '.+');
});
