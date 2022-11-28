<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;

class ProfileController extends Controller
{


    public static function getProfile()
    {
        // if not connected, redirect to login
        if (!Auth::check()) {
            return redirect('/login');
        }
        //get user
        $user = Auth::user();
        return view('profile', ['user' => $user]);
    }
    public static function deleteProfile()
    {
        DB::table('users')->where('id', '=', Auth::user()->id)->delete();
        return redirect('/login');
    }
    public static function editAccount(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'email' => 'required|email',
        ]);
        //check if email and username already exists
        $user = DB::table('users')->where('email', '=', $request->email)->first();
        if ($user != null && $user->id != Auth::user()->id) {
            return back()->withErrors([
                'email' => 'The provided email is already used.',
            ])->onlyInput('email');
        }
        $user = DB::table('users')->where('username', '=', $request->username)->first();
        if ($user != null && $user->id != Auth::user()->id) {
            return back()->withErrors([
                'username' => 'The provided username is already used.',
            ])->onlyInput('username');
        }
        if ($request->input('password') != null) {
            $request->validate([
                'password' => 'required|min:8',
            ]);
            DB::table('users')->where('id', '=', Auth::user()->id)->update(['username' => $request->username, 'email' => $request->email, 'password' => bcrypt($request->input('password'))]);
            return back()->with('message', 'Profile Updated');
        } else {
            DB::table('users')->where('id', '=', Auth::user()->id)->update(['username' => $request->username, 'email' => $request->email]);
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
        DB::table('users')->insert(['username' => $request->username, 'email' => $request->email, 'password' => bcrypt($request->password), 'level' => 1, 'is_admin' => false]);
        return redirect('/login');
    }
    public static function register()
    {
        return view('register');
    }
}