<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PC extends Model
{
    use HasFactory;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'pc';
    public $timestamps = false;

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
    /**
     * The user who mastered this energy.
     */
    public static function addLevel($id)
    {
        /** 
         * @param  \Illuminate\Http\Request  $request
         * @param  string  $id
         * @return \Illuminate\Http\Response*/
        //use models 
        $pc = PC::where('id', $id)->first();
        $pc->level = $pc->level + 1;
        $pc->save();
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }
    public function pokemon()
    {
        return $this->belongsTo(Pokemon::class, 'pokemon_id', 'pokemon_id');
    }
    public static function addPokemonToTeam($entityId)
    {
        $pc = PC::where('id', $entityId)->first();
        $user = User::where('id', $pc->user_id)->first();
        $count = PC::where('user_id', $pc->user_id)->where('team', true)->count();

        //check if user has mastered the energy of the pokemon
        $energy = Energy::where('name', $pc->pokemon->energy)->first();
        $mastered = Mastered::where('user_id', $pc->user_id)->where('energy_id', $energy->id)->count();

        if ($pc->team == true) {
            $pc->team = false;
            echo json_encode("removed from team");
        } else if ($count >= 3) {
            echo json_encode("team full");
        } else if ($pc->level > $user->level) {
            echo json_encode("level too low");
        } else if ($mastered == 0) {
            echo json_encode("energy not mastered");
        } else if ($pc->team == false) {
            $pc->team = true;
            echo json_encode("added to team");
        }
        $pc->save();
    }
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'level',
        'team',
    ];
}