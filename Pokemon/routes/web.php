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

Route::get('/', 'App\Http\Controllers\PokemonController@displayAll');
Route::get('/test', 'App\Http\Controllers\PokemonController@getPokedex');