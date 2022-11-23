<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;
use App\Models\Energy;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class PokemonController extends Controller
{


    public static function displayAll()
    {
        $pokemons = DB::table('pokemon')->get();
        return view('listPokemon', ['pokemons' => $pokemons]);
    }
    public static function getPokemon(Request $request, $id)
    {
        /** 
         * @param  \Illuminate\Http\Request  $request
         * @param  string  $id
         * @return \Illuminate\Http\Response*/
        return (DB::table('pokemon')->where('id', $id)->first());
    }
}