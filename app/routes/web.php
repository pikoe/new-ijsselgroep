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

Route::get('/', function () {
	return view('welcome');
});

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
	Route::group(['prefix' => 'pages', 'as' => 'pages.'], function () {
		Route::get('', ['uses' => 'PagesController@index', 'as' => 'index']);
		Route::any('add', ['uses' => 'PagesController@add', 'as' => 'add']);
		Route::any('edit/{page}', ['uses' => 'PagesController@edit', 'as' => 'edit']);
		Route::post('delete/{page}', ['uses' => 'PagesController@delete', 'as' => 'delete']);
		Route::post('reorder', ['uses' => 'PagesController@reorder', 'as' => 'reorder']);
	});
});

Route::get('/article', function () {
	return view('article');
});
Route::get('/leeftijdsgroepen/welpen', 'AgeGroupsController@welpen');
