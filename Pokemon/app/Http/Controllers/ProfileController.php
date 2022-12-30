<?php

namespace App\Http\Controllers;

use App\Models\pc;
use App\Models\Pokemon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;

class ProfileController extends Controller
{

    public static function getMe()
    {
        return Auth::user();
    }
    public static function getProfile()
    {
        if (!Auth::check()) {
            return redirect('/login');
        }
        $user = Auth::user();
        $pokemonsId = pc::where('user_id', '=', $user->id)->get();
        $pokemonData = [];
        for ($i = 0; $i < count($pokemonsId); $i++) {
            $pokemonData[$i] = Pokemon::where('id', '=', $pokemonsId[$i]->pokemon_id)->first();
        }
        $fights = DB::table('fight')
            ->where('winner_id', '=', $user->id)
            ->orWhere('loser_id', '=', $user->id)
            ->get();

        //add the front image to the pokemon
        $sprites = [];
        for ($i = 0; $i < count($fights); $i++) {
            $spriteWinner = [];
            $spriteLoser = [];
            $pokemon1 = pc::where('id', '=', $fights[$i]->winner_pokemon_id1)->first();
            if ($pokemon1 != null) {
                $pokemon1 = Pokemon::where('id', '=', $pokemon1->pokemon_id)->first();
                array_push($spriteWinner, $pokemon1->front);
            }
            $pokemon2 = pc::where('id', '=', $fights[$i]->winner_pokemon_id2)->first();
            if ($pokemon2 != null) {
                $pokemon2 = Pokemon::where('id', '=', $pokemon2->pokemon_id)->first();
                array_push($spriteWinner, $pokemon2->front);
            }
            $pokemon3 = pc::where('id', '=', $fights[$i]->winner_pokemon_id3)->first();
            if ($pokemon3 != null) {
                $pokemon3 = Pokemon::where('id', '=', $pokemon3->pokemon_id)->first();
                array_push($spriteWinner, $pokemon3->front);
            }
            $pokemon4 = pc::where('id', '=', $fights[$i]->loser_pokemon_id1)->first();
            if ($pokemon4 != null) {
                $pokemon4 = Pokemon::where('id', '=', $pokemon4->pokemon_id)->first();
                array_push($spriteLoser, $pokemon4->front);
            }
            $pokemon5 = pc::where('id', '=', $fights[$i]->loser_pokemon_id2)->first();
            if ($pokemon5 != null) {
                $pokemon5 = Pokemon::where('id', '=', $pokemon5->pokemon_id)->first();
                array_push($spriteLoser, $pokemon5->front);
            }
            $pokemon6 = pc::where('id', '=', $fights[$i]->loser_pokemon_id3)->first();
            if ($pokemon6 != null) {
                $pokemon6 = Pokemon::where('id', '=', $pokemon6->pokemon_id)->first();
                array_push($spriteLoser, $pokemon6->front);
            }
            array_push($sprites, [$spriteWinner, $spriteLoser]);
        }
        return view('profile', ['user' => $user, 'pokemonPC' => $pokemonsId, 'pokemonData' => $pokemonData, 'fight' => $fights, 'sprites' => $sprites]);
    }
    public static function deleteProfile()
    {

        User::where('id', Auth::user()->id)->delete();
        return redirect('/login');
    }
    public static function editAccount(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'email' => 'required|email',
        ]);
        //check if email and username already exists
        $user = User::where('email', $request->email)->first();
        if ($user != null && $user->id != Auth::user()->id) {
            return back()->withErrors([
                'email' => 'The provided email is already used.',
            ])->onlyInput('email');
        }
        $user = User::where('username', $request->username)->first();
        if ($user != null && $user->id != Auth::user()->id) {
            return back()->withErrors([
                'username' => 'The provided username is already used.',
            ])->onlyInput('username');
        }
        if ($request->input('password') != null) {
            $request->validate([
                'password' => 'required|min:8',
            ]);
            User::where('id', Auth::user()->id)->update(['username' => $request->username, 'email' => $request->email, 'password' => bcrypt($request->password)]);
            return back()->with('message', 'Profile Updated');
        } else {
            User::where('id', Auth::user()->id)->update(['username' => $request->username, 'email' => $request->email]);
            // }
            return back()->with('message', 'Profile Updated');
        }
    }
    public static function createAccount(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);
        User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'level' => 1,
            'beaten' => 0,
            'is_admin' => false,
        ]);
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            return redirect()->intended('/');
        }
    }
    public static function register()
    {
        return view('register');
    }
}