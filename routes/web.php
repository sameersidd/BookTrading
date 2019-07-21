<?php
use Illuminate\Support\Facades\Route;

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


//Profile Related Routes
Route::get('/home', 'HomeController@index')->name('home'); //Homepage of every User
Route::get('/p/{id}', 'ProfileController@view');
Route::get('/p/{id}', 'ProfileController@editPage')->middleware('auth');
Route::put('/p/{id}', 'ProfileController@update')->middleware('auth');

//Book Related Routes
Route::get('/add/book', 'BookController@addPage')->middleware('auth');
Route::post('/add/book', 'BookController@add')->middleware('auth');
Route::get('/book/{id}', 'BookController@view');
Route::get('/book/{id}', 'BookController@editPage')->middleware('auth');
Route::put('/book/{id}', 'BookController@update')->middleware('auth');
Route::delete('/book/{id}', 'BookController@delete')->middleware('auth');

//Trade Related Routes
Route::post('/trade', 'TradeOfferController@create')->middleware('auth');
Route::get('/trade/{id}', 'TradeOfferController@view')->middleware('auth');
Route::put('/trade/{id}', 'TradeOfferController@update')->middleware('auth');
Route::delete('/trade/{id}', 'TradeOfferController@delete')->middleware('auth');
Route::post('/trade', 'TradeOfferController@create')->middleware('auth');
