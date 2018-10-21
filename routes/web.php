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

Route::get('/home', 'HomeController@index')->name('home');



Route::resource('users', 'UserController');

// Route::get('{path}', 'HomeController@index')->where('path', '([A-z\d-\/_.]+)?');

//Route::get('{path}',"HomeController@lost")->where( 'path', '([A-z\d-\/_.]+)?' );

// Route::get('/{path?}', 'HomeController@index')->where('path', '.*');
// Route::get('/{vue_capture?}', function () {
//     return view('layouts.backend.master');
// })->where('vue_capture', '[\/\w\.-]*');

