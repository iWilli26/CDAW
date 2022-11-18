<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //find the energy id associated with the pokemon and put it into the energy column
        $pokemons = DB::table('pokemon')->get();
        foreach ($pokemons as $pokemon) {
            $energy_id = DB::table('energy')->where('name', $pokemon->energy)->first()->energy_id;
            DB::table('pokemon')->where('id', $pokemon->id)->update(['energy' => $energy_id]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};