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
    public static function getPokemonWithId(Request $request, $id)
    {
        /** 
         * @param  \Illuminate\Http\Request  $request
         * @param  string  $id
         * @return \Illuminate\Http\Response*/
        return (DB::table('pokemon')->where('id', $id)->first());
    }
    public static function getPokemonWithName(Request $request, $name)
    {
        //use models to get the pokemon with the name
        /** 
         * @param  \Illuminate\Http\Request  $request
         * @param  string  $name
         * @return \Illuminate\Http\Response*/
        return (DB::table('pokemon')->where('name', $name)->first());
    }
}