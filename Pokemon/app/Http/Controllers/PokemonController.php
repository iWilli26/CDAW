<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;
use App\Models\Energy;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Pokemon;
use Illuminate\Database\Eloquent\Model;

class PokemonController extends Controller
{
    public static function displayAll()
    {
        $pokemons = Pokemon::all();
        return view('listPokemon', ['pokemons' => $pokemons]);
    }
}