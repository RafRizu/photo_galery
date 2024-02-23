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

// Route::get('/', function () {
//     return view('welcome');
// });
Route::redirect('/','/login');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard','App\Http\Controllers\GaleriController@index')->name('dashboard');
    Route::get('/album/{slug}', 'App\Http\Controllers\GaleriController@showGaleri')->name('albums.show');

    Route::get('/galerimu','App\Http\Controllers\GaleriController@yourGaleri')->name('yourGaleri');
    Route::get('/creategaleri','App\Http\Controllers\GaleriController@createGaleri')->name('createGaleri');
    Route::post('/storegaleri','App\Http\Controllers\GaleriController@storeGaleri')->name('storeGaleri');
    Route::delete('/deletegaleri/{slug}','App\Http\Controllers\GaleriController@deleteGaleri')->name('deleteGaleri');
    Route::delete('/deleteFoto/{slug}','App\Http\Controllers\GaleriController@deleteFoto')->name('deleteFoto');
    Route::get('/createfoto/{id_album}','App\Http\Controllers\GaleriController@createFoto')->name('createFoto');
    Route::post('/storefoto','App\Http\Controllers\GaleriController@storeFoto')->name('storeFoto');

    Route::get('/foto/{slug}', 'App\Http\Controllers\GaleriController@showFoto')->name('showFoto');
    Route::post('/like/{slug}', 'App\Http\Controllers\GaleriController@like')->name('like.store');

    Route::post('/comment/{slug}', 'App\Http\Controllers\GaleriController@storeComment')->name('comment.store');

    // Route::post('/storegaleri','App\Http\Controllers\GaleriController@storeGaleri')->name('storeGaleri');
});
