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

Route::get('/', 'HomeController@index')->name('home');
Route::get('/home', 'HomeController@index');
Route::post('/login','UserController@login');
//Route::post('/register', 'Auth\RegisterController@create');
//Route::post('/login', 'Auth\LoginController@authenticate')->name('login');

Route::get('/users/{id}', 'UserController@show')->name('users.id');
Route::post('/users/{id}', 'UserController@show')->name('users.id');
Route::get('/users/{id}/statistics', 'UserController@showStatistics')->name('users.statistics');
Route::get('/items/form', 'ItemController@create')->name('newItemView');
Route::post('/items/form', 'ItemController@store')->name('newItemSubmit');

Route::get('/items/{id}/edit', 'ItemController@editShow')->name('items.getEdit');
//Route::post('/items/{id}/edit', array('uses' => 'ItemController@editUpdate', 'as'=>'items.editSubmit'));
Route::post('/items/{id}/edit', 'ItemController@editUpdate')->name('items.editSubmit');

Route::get('items/{id}/delete', 'ItemController@delete')->name('items.delete');

Route::get('items/{id}/post', 'ItemController@post')->name('items.post');
Route::post('items/{id}/post', 'PostController@postSubmit')->name('posts.submit');

Route::get('posts/{id}/delete', 'PostController@delete')->name('posts.delete');
Route::get('posts/{id}/edit', 'PostController@editShow')->name('posts.editShow');
Route::post('posts/{id}/edit', 'PostController@editSubmit')->name('posts.editSubmit');

Route::get('posts/{id}/bid', 'PostController@bidPost')->name('posts.bidPost');
Route::post('posts/{id}/bid', 'PostController@bidPointSubmit')->name('posts.bidPointSubmit');

Route::get('/markets', 'PostController@marketOverview')->name('markets');

Route::get('bids/{id}/delete', 'BidController@delete')->name('bids.delete');
Route::get('bids/{id}/reject', 'BidController@reject')->name('bids.reject');
Route::get('bids/{id}/accept', 'BidController@accept')->name('bids.accept');
Route::get('bids/{id}/edit', 'BidController@editShow')->name('bids.editShow');
Route::post('bids/{id}/edit', 'BidController@editSubmit')->name('bids.editSubmit');

Route::get('/users/{id}/transactions', 'UserController@transactionsDisplay')->name('users.transactionDisplay');

Route::get('/loans/{id}/return', 'LoanController@returnLoan')->name('loans.returnLoan');

Route::get('/admin', 'AdminController@direct')->name('admin.direct');
Route::get('/admin/deleteUser/{id}', 'AdminController@deleteUser')->name('admin.deleteUser');
Route::get('/admin/newUser', 'AdminController@newUser')->name('admin.newUser');
Route::get('/admin/editUser/{id}', 'AdminController@editUser')->name('admin.editUser');
Route::post('/admin/editUser/{id}', 'AdminController@editUserSubmit')->name('admin.editUserSubmit');
