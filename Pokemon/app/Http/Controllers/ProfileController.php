<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;


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
        return view('registerUser', ['user' => $user]);
    }
    public static function deleteProfile()
    {
        DB::table('users')->where('id', '=', Auth::user()->id)->delete();
        return redirect('/login');
    }
    public static function updateProfile(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'email' => 'required|email',
        ]);
        // if ($request->input('password') != null) {
        //     $request->validate([
        //         'password' => 'required|min:8',
        //     ]);
        //     DB::table('users')->where('id', '=', Auth::user()->id)->update(['name' => $request->input('name'), 'email' => $request->input('email'), 'password' => bcrypt($request->input('password'))]);
        // } else {
        DB::table('users')->where('id', '=', Auth::user()->id)->update(['name' => $request->name, 'email' => $request->email]);
        // }
        return back()->with('message', 'Profile Updated');
    }
    public static function createAccount(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);
        DB::table('users')->insert(['name' => $request->name, 'email' => $request->email, 'password' => bcrypt($request->password)]);
        return redirect('/login');
    }
    public static function register()
    {
        return view('register');
    }
}