<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Fight extends Model
{
    public static function addFight(Request $request)
    {
        $content = json_decode($request->getContent());
        var_dump($content);
        $pokemonWinner = $content->pokemonWinner;
        $pokemonLoser = $content->pokemonLoser;
        $winner_pokemon_id1 = null;
        $winner_pokemon_id2 = null;
        $winner_pokemon_id3 = null;
        $loser_pokemon_id1 = null;
        $loser_pokemon_id2 = null;
        $loser_pokemon_id3 = null;
        for ($i = 0; $i < count($pokemonWinner); $i++) {
            if ($i == 0) {
                $winner_pokemon_id1 = $pokemonWinner[$i];
            } else if ($i == 1) {
                $winner_pokemon_id2 = $pokemonWinner[$i];
            } else if ($i == 2) {
                $winner_pokemon_id3 = $pokemonWinner[$i];
            }
        }
        for ($i = 0; $i < count($pokemonLoser); $i++) {
            if ($i == 0) {
                $loser_pokemon_id1 = $pokemonLoser[$i];
            } else if ($i == 1) {
                $loser_pokemon_id2 = $pokemonLoser[$i];
            } else if ($i == 2) {
                $loser_pokemon_id3 = $pokemonLoser[$i];
            }
        }
        Fight::create([
            'winner_id' => $content->winner,
            'loser_id' => $content->loser,
            'winner_pokemon_id1' => $winner_pokemon_id1,
            'winner_pokemon_id2' => $winner_pokemon_id2,
            'winner_pokemon_id3' => $winner_pokemon_id3,
            'loser_pokemon_id1' => $loser_pokemon_id1,
            'loser_pokemon_id2' => $loser_pokemon_id2,
            'loser_pokemon_id3' => $loser_pokemon_id3,
        ]);
    }
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'fight';
    public $timestamps = false;
    /**
     * The database connection that should be used by the model.
     *
     * @var string
     */
    protected $connection = 'mysql';
    protected $fillable = [
        'winner_id',
        'loser_id',
        'winner_pokemon_id1',
        'loser_pokemon_id1',
        'winner_pokemon_id2',
        'loser_pokemon_id2',
        'winner_pokemon_id3',
        'loser_pokemon_id3',
    ];
}