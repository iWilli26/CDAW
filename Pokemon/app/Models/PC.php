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
        //count the number of pokemon in the team
        $count = PC::where('user_id', $pc->user_id)->where('team', true)->count();
        if ($pc->team == true) {
            $pc->team = false;
        } else if ($count >= 3) {
            echo $count;
            echo "tooMany";
            return;
        } else if ($pc->team == false) {
            $pc->team = true;
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