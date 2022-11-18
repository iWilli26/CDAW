<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class EnergySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Etape 1
        $pokemon_types = [
            'normal',
            'fighting',
            'flying',
            'poison',
            'ground',
            'rock',
            'bug',
            'ghost',
            'steel',
            'fire',
            'water',
            'grass',
            'electric',
            'psychic',
            'ice',
            'dragon',
            'dark',
            'fairy',
        ];
        //Etape 2
        foreach ($pokemon_types as $pokemon_type) {
            DB::table('energy')->insert([
                'name' => $pokemon_type,
            ]);
        }
        

        //Etape 2
        //\App\Models\Energy::factory(10)->create();
    }
}