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
        return view('profile', ['user' => $user, 'pokemonPC' => $pokemonsId, 'pokemonData' => $pokemonData]);
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
            'is_admin' => false,
        ]);
        //Login
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