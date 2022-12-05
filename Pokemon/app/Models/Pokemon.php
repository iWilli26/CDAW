<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class Pokemon extends Model
{
    public static function addPokemon(Request $request)
    {
        $content = json_decode($request->getContent());
        DB::table('pc')->insert([
            'user_id' => $content->userId,
            'pokemon_id' => $content->pokemonId,
            'level' => 1,
        ]);
        return "success";
    }
    public static function getPokemonById($id)
    {
        /** 
         * @param  \Illuminate\Http\Request  $request
         * @param  string  $id
         * @return \Illuminate\Http\Response*/
        return (DB::table('pokemon')->where('id', $id)->first());
    }
    public static function getPokemonByName($name)
    {
        //use models to get the pokemon with the name
        /** 
         * @param  \Illuminate\Http\Request  $request
         * @param  string  $name
         * @return \Illuminate\Http\Response*/
        return (DB::table('pokemon')->where('name', $name)->first());
    }
    //
    /**
     * Get the energy associated with the pokemon.
     */
    public function energy()
    {
        return $this->hasOne(Energy::class);
    }
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'pokemon';
    /**
     * The database connection that should be used by the model.
     *
     * @var string
     */
    protected $connection = 'mysql';
    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'pokemon_id';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'pv_max',
        'level',
        'image',
        'attack',
        'defense',
        'special_defense',
        'special_attack',
        'evolve_to',
    ];
}