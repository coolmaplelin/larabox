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
})->name('homepage');


// Admin Interface Routes
Route::group(['prefix' => 'admin', 'middleware' => 'admin'], function()
{
  // Backpack\CRUD: Define the resources for the entities you want to CRUD.
    CRUD::resource('user', 'Admin\UserCrudController');
    CRUD::resource('page', 'Admin\PageCrudController');

  // Custom ADMIN routes
    Route::get('page/{id}/gallery', 'Admin\PageCrudController@gallery');
  
  // [...] other routes
});

// Laravel build in Auth module
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

// Jquery file upload main controller
Route::get('/upload', 'FileUploadController@index');
Route::group(['prefix' => 'fileupload'], function()
{
	Route::match(['get', 'post', 'delete'], 'handle/{entity_name}/{entity_id}', 'FileUploadController@handle');
	Route::post('saveorder/{entity_name}/{entity_id}', 'FileUploadController@saveorder');
	Route::post('saveextras/{entity_name}/{entity_id}', 'FileUploadController@saveextras');
});



