<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;
use App\Models\Energy;

class listePokemonsController extends Controller
{

    public static function getSinglePokemon($name)
    {
        // $client = new Client();
        // $res = $client->request('GET', 'https://pokeapi.co/api/v2/pokemon/ditto', [
        //     // 'form_params' => [
        //     //     'client_id' => 'test_id',
        //     //     'secret' => 'test_secret',
        //     // ]
        // ]);
        // echo $res->getBody();

        $response = Http::get('https://pokeapi.co/api/v2/pokemon/' . $name);

        // foreach (Energy::all() as $energy) {
        //     echo $energy->name;
        // }
        return $response->object();
    }
    public static function getAll()
    {
        $pokemons = DB::table('pokemon')->get();
        return view('listPokemon', ['pokemons' => $pokemons]);
    }
}