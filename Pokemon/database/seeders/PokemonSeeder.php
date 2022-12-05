<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\Pokemon;
use Illuminate\Support\Facades\Http;

class PokemonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //get the next evolution of a pokemon
        function getNextEvolution($id)
        {
            //get evolution chain id
            $response = Http::get('https://pokeapi.co/api/v2/pokemon-species/' . $id);
            $response = json_decode($response->body());
            $evolutionChainId = $response->evolution_chain->url;
            $evolutionChainId = explode('/', $evolutionChainId);
            $evolutionChainId = $evolutionChainId[6];
            //get every evolution
            $response = Http::get('https://pokeapi.co/api/v2/evolution-chain/' . $evolutionChainId);
            $response = json_decode($response->body());
            $evolutions = [];
            $evolutions[] = $response->chain->species->name;
            foreach ($response->chain->evolves_to as $evolution) {
                $evolutions[] = $evolution->species->name;
                if (isset($evolution->evolves_to[0])) {
                    $evolutions[] = $evolution->evolves_to[0]->species->name;
                }
            }
            return $evolutions;
        }
        function getSinglePokemon($name)
        {

            $response = Http::get('https://pokeapi.co/api/v2/pokemon/' . $name);
            return $response->object();
        }
        function getPokedex()
        {
            $response = Http::get("https://pokeapi.co/api/v2/pokedex/5/");
            return $response->object();
        }

        foreach (getPokedex()->pokemon_entries as $poke) {

            $pokemon_id = Str::of($poke->pokemon_species->url)->explode('/')[6];
            $pokemon = getSinglePokemon($pokemon_id);
            $energy_id = DB::table('energy')->where('name', $pokemon->types[0]->type->name)->first()->id;
            // $evolution_chain = getNextEvolution($pokemon_id);
            DB::table('pokemon')->insert([
                'name' => $pokemon->name,
                'pv_max' => $pokemon->stats[0]->base_stat,
                'front' => $pokemon->sprites->front_default,
                'back' => $pokemon->sprites->back_default,
                'attack' => $pokemon->stats[1]->base_stat,
                'defense' => $pokemon->stats[2]->base_stat,
                'special_defense' => $pokemon->stats[2]->base_stat,
                'special_attack' => $pokemon->stats[3]->base_stat,
                'energy_id' => $energy_id,
            ]);
        }
    }
}