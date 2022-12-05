<?php

use Illuminate\Support\Facades\Route;
//import model Pokemon
use App\Models\Pokemon;
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

Route::get('/', array('as' => 'pokedex', 'uses' => 'App\Http\Controllers\PokemonController@displayAll'));
Route::get('/login', array('as' => 'login', 'uses' => 'App\Http\Controllers\LoginController@login'));
Route::post('/login', 'App\Http\Controllers\LoginController@authenticate');
Route::get('/logout', 'App\Http\Controllers\LoginController@logout');
Route::get('/profile', array('as' => 'profile', 'uses' => 'App\Http\Controllers\ProfileController@getProfile'));
Route::get('/deleteProfile', array('as' => 'deleteProfile', 'uses' => 'App\Http\Controllers\ProfileController@deleteProfile'));
Route::get('/register', array('as' => 'register', 'uses' => 'App\Http\Controllers\LoginController@register'));

Route::post('/editAccount', array('as' => 'editAccount', 'uses' => 'App\Http\Controllers\ProfileController@editAccount'));
Route::post('/createAccount', array('as' => 'createAccount', 'uses' => 'App\Http\Controllers\ProfileController@createAccount'));

Route::get('/firstEnergy/', array('as' => 'firstEnergy', 'uses' => 'App\Http\Controllers\EnergyController@getFirstEnergy'));

Route::get('/pokemonId/{id}', array('as' => 'pokemon', 'uses' => 'App\Models\Pokemon@getPokemonById'));
Route::get('/pokemonName/{name}', array('as' => 'pokemon', 'uses' => 'App\Models\Pokemon@getPokemonByName'));