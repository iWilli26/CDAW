<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;
use App\Models\Energy;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use App\Models\pc;
use App\Models\User;
use App\Models\Pokemon;

class BattleController extends Controller
{
    public static function battleMenu()
    {
        if (!Auth::check()) {
            return redirect('/login');
        }
        $me = Auth::user();
        $count = pc::where('user_id', '=', $me->id)->count();
        if ($count == 0) {
            return redirect('/firstEnergy');
        }
        $users = User::all();
        //remove users who have no pokemon
        foreach ($users as $key => $user) {
            $count = pc::where('user_id', '=', $user->id)->count();
            if ($count == 0) {
                unset($users[$key]);
            }
        }
        return view('battleMenu', ['me' => $me, 'users' => $users]);
    }

    public static function battleStart($mode, $id)
    {
        /** 
         * @param  \Illuminate\Http\Request  $request
         * @param string $mode
         * @param  int $id
         * @return \Illuminate\Http\Response*/
        if (!Auth::check()) {
            return redirect('/login');
        }
        $user = Auth::user();
        $count = pc::where('user_id', '=', $user->id)->count();
        if ($count == 0) {
            return redirect('/firstEnergy');
        }
        $opponent = User::find($id);
        $opponentPokemon = pc::where('user_id', '=', $id)->get();
        foreach ($opponentPokemon as $pokemon) {
            $pokemon->data = Pokemon::getPokemonById($pokemon->pokemon_id);
        }
        $myPokemon = pc::where('user_id', '=', $user->id)->get();
        foreach ($myPokemon as $pokemon) {
            $pokemon->data = Pokemon::getPokemonById($pokemon->pokemon_id);
        }
        return view('battle', ['me' => $user, 'myPokemon' => $myPokemon, 'opponent' => $opponent, 'opponentPokemon' => $opponentPokemon, 'mode' => $mode]);
    }
}