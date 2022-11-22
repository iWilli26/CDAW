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

Route::get('/bruh/{name}/{age}', function ($name, $age) {
    return $name . ' a ' . $age . ' ans';
})->where(['age' => '^[0-9]*$', 'name', '^[a-zA-Z]+$']);

Route::get('/', array('as' => 'pokedex', 'uses' => 'App\Http\Controllers\PokemonController@displayAll'));
Route::get('/test', 'App\Http\Controllers\PokemonController@getPokedex');
Route::get('/login', array('as' => 'login', 'uses' => 'App\Http\Controllers\LoginController@login'));
Route::post('/login', 'App\Http\Controllers\LoginController@authenticate');
Route::get('/logout', 'App\Http\Controllers\LoginController@logout');
Route::get('/profile', array('as' => 'profile', 'uses' => 'App\Http\Controllers\ProfileController@getProfile'));
Route::get('/deleteProfile', array('as' => 'deleteProfile', 'uses' => 'App\Http\Controllers\ProfileController@deleteProfile'));
Route::get('/register', array('as' => 'register', 'uses' => 'App\Http\Controllers\LoginController@register'));
Route::get('/registerUser',  function () {
    return view('register');
});
Route::get('/createAccount', array('as' => 'createAccount', 'uses' => 'App\Http\Controllers\ProfileController@createAccount'));