<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;

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
        return $response->object();
    }
    public static function getLotPokemon()
    {
        $response = Http::get('https://pokeapi.co/api/v2/pokemon?limit=100&offset=0');
        return $response->object();
    }
}