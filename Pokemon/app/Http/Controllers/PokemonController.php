<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;
use App\Models\Energy;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Pokemon;

class PokemonController extends Controller
{
    public static function displayAll()
    {
        $pokemons = DB::table('pokemon')->get();
        return view('listPokemon', ['pokemons' => $pokemons]);
    }
}