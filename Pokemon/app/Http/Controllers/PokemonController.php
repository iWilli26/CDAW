<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;
use App\Models\Energy;

class PokemonController extends Controller
{

    
    public static function displayAll()
    {
        $pokemons = DB::table('pokemon')->get();
        return view('listPokemon', ['pokemons' => $pokemons]);
    }
    
}