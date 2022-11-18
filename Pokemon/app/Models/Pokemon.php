<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;

class Pokemon extends Model
{
    public static function getSinglePokemon($name)
    {
        $response = Http::get('https://pokeapi.co/api/v2/pokemon/' . $name);
        return $response->object();
    }
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
        'special_defense',
        'special_attack',
    ];
}