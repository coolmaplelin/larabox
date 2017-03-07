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

Route::get('/upload', 'FileUploadController@index');
Route::get('/upload/image', 'FileUploadController@uploadimage');
Route::post('/upload/image', 'FileUploadController@uploadimage');
Route::delete('/upload/image', 'FileUploadController@uploadimage');


// Admin Interface Routes
Route::group(['prefix' => 'admin', 'middleware' => 'admin'], function()
{
  // Backpack\CRUD: Define the resources for the entities you want to CRUD.
    CRUD::resource('user', 'Admin\UserCrudController');
    CRUD::resource('page', 'Admin\PageCrudController');
  
  // [...] other routes
});

// Laravel build in Auth module
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
