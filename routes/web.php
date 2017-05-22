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
    CRUD::resource('customform', 'Admin\CustomFormCrudController');
    CRUD::resource('customformentry', 'Admin\CustomFormEntryCrudController');
    CRUD::resource('redirect', 'Admin\RedirectCrudController');

  // Custom ADMIN routes
    Route::get('page/{id}/gallery', 'Admin\PageCrudController@gallery');
    Route::post('navigation/save', 'Admin\MyAdminController@saveNav');
    Route::get('navigation/{nav_type}', 'Admin\MyAdminController@showNav')->name('adminnav');
    Route::get('customformentry/{id}/view', 'Admin\CustomFormEntryCrudController@view');
  
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

// Custom Form Module
Route::group(['prefix' => 'form'], function()
{
  Route::get('/email', 'CustomFormController@testemail');
  Route::get('/{slug}', 'CustomFormController@show');
  Route::post('/{slug}', 'CustomFormController@saveentry');
  Route::get('/{slug}/thankyou', 'CustomFormController@thankyou');
});

// PDF Generator Moduel
Route::group(['prefix' => 'pdf'], function()
{
  Route::get('/test', 'PDFController@test');
  Route::get('/header', 'PDFController@header')->name('pdf_header');
  Route::get('/footer', 'PDFController@footer')->name('pdf_footer');
});


// CMS Page 
// All url that not match above routing and not start with 'admin' will go to here
// Route::get('/{wildcard}', 'PageController@index');
// Route::pattern('wildcard', '^(?!admin.*$).*');
Route::get('/{any}', 'PageController@index')->where('any', '^(?!admin.*$).*');