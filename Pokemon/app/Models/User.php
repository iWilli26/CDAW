<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
        'email',
        'password',
        'level',
        'beaten',
        'is_admin',
    ];

    public function energies()
    {
        return $this->belongsToMany(Energy::class, 'mastered', 'user_id', 'energy_id');
    }

    public function pokemons()
    {
        return $this->belongsToMany(Pokemon::class, 'pc', 'user_id', 'pokemon_id');
    }

    public static function getUserById($id)
    {
        /** 
         * @param  \Illuminate\Http\Request  $request
         * @param  string  $id
         * @return \Illuminate\Http\Response*/
        return (DB::table('users')->where('id', $id)->first());
    }
    public static function addLevel($id)
    {
        /** 
         * @param  \Illuminate\Http\Request  $request
         * @param  string  $id
         * @return \Illuminate\Http\Response*/
        //use models 
        $user = User::find($id);
        $user->level = $user->level + 1;
        if ($user->level > 10) {
            $user->level = 10;
        }
        $user->save();
    }
    public static function addBeaten($id)
    {
        /** 
         * @param  \Illuminate\Http\Request  $request
         * @param  string  $id
         * @return \Illuminate\Http\Response*/
        //use models 
        $user = User::find($id);
        $user->beaten = $user->beaten + 1;
        $user->save();
    }
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}