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

//Liste des pages
Route::get('/', array('as' => 'pokedex', 'uses' => 'App\Http\Controllers\PokemonController@displayAll'));
Route::get('/battleMenu', array('as' => 'battleMenu', 'uses' => 'App\Http\Controllers\BattleController@battleMenu'));
Route::get('/profile', array('as' => 'profile', 'uses' => 'App\Http\Controllers\ProfileController@getProfile'));
Route::get('/login', array('as' => 'login', 'uses' => 'App\Http\Controllers\LoginController@login'));
Route::get('/firstEnergy/', array('as' => 'firstEnergy', 'uses' => 'App\Http\Controllers\EnergyController@getFirstEnergy'));
Route::get('/battle/{mode}/{id}', array('as' => 'battle', 'uses' => 'App\Http\Controllers\BattleController@battleStart'));

//Route pour les requêtes ajax concernant le User et son Profile
Route::post('/login', 'App\Http\Controllers\LoginController@authenticate');
Route::get('/logout', 'App\Http\Controllers\LoginController@logout');
Route::get('/register', array('as' => 'register', 'uses' => 'App\Http\Controllers\LoginController@register'));
Route::get('/deleteProfile', array('as' => 'deleteProfile', 'uses' => 'App\Http\Controllers\ProfileController@deleteProfile'));
Route::post('/editAccount', array('as' => 'editAccount', 'uses' => 'App\Http\Controllers\ProfileController@editAccount'));
Route::post('/createAccount', array('as' => 'createAccount', 'uses' => 'App\Http\Controllers\ProfileController@createAccount'));

//Route pour retrouver les pokemons
Route::get('/pokemonId/{id}', array('as' => 'pokemon', 'uses' => 'App\Models\Pokemon@getPokemonById'));
Route::get('/pokemonName/{name}', array('as' => 'pokemon', 'uses' => 'App\Models\Pokemon@getPokemonByName'));

//Route pour les requêtes ajax concernant les pokemons
Route::post('/addPokemon', array('as' => 'addPokemon', 'uses' => 'App\Models\Pokemon@addPokemon'));
Route::post('/releasePokemon', array('as' => 'releasePokemon', 'uses' => 'App\Models\Pokemon@releasePokemon'));

//Route pour ajouter une énergie
Route::post('/addEnergy', array('as' => 'addEnergy', 'uses' => 'App\Models\Energy@addEnergy'));

//Route pour retrouver les énergies
Route::get('/energyName/{name}', array('as' => 'energy', 'uses' => 'App\Models\Energy@getEnergyByName'));

//Route pour recevoir les infos du profil
Route::get('/me', array('as' => 'me', 'uses' => 'App\Http\Controllers\ProfileController@getMe'));

//Ajoute le pokemon dans l'équipe ou le retire si il y est déjà
Route::post('/pokemonTeam/{id}', array('as' => 'addEnergy', 'uses' => 'App\Models\pc@addPokemonToTeam'));

//AJoute un niveau au dresseur
Route::post('/addLevel/{id}', array('as' => 'addLevel', 'uses' => 'App\Models\user@addLevel'));

//Ajoute un niveau au pokemon
Route::post('/addLevelPokemon/{id}', array('as' => 'addLevel', 'uses' => 'App\Models\pc@addLevel'));

//Ajoute un combat à la base de donnée
Route::post('/addFight/', array('as' => 'addLevel', 'uses' => 'App\Models\fight@addFight'));

//Ajoute un pokemon battu à la base de donnée
Route::post('/addBeaten/{id}', array('as' => 'addLevel', 'uses' => 'App\Models\user@addBeaten'));