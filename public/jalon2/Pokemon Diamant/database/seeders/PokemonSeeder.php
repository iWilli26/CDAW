<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\listePokemonsController;
use Illuminate\Support\Str;

class PokemonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 388; $i < 490; $i++) {
            $pokemon = listePokemonsController::getSinglePokemon($i);
            DB::table('pokemon')->insert([
                'name' => $pokemon->name,
                'pv_max' => $pokemon->stats[0]->base_stat,
                'level' => 1,
                'image' => $pokemon->sprites->front_default,
                'normal_attack' => $pokemon->stats[1]->base_stat,
                'special_defense' => $pokemon->stats[2]->base_stat,
                'special_attack' => $pokemon->stats[3]->base_stat,
                'energy' => $pokemon->types[0]->type->name,
            ]);
        }
    }
}