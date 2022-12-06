<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;
use App\Models\Energy;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BattleController extends Controller
{
    public static function battleMenu()
    {
        if (!Auth::check()) {
            return redirect('/login');
        }
        $user = Auth::user();
        $count = DB::table('pc')->where('user_id', '=', $user->id)->count();
        if ($count == 0) {
            return redirect('/firstEnergy');
        }
        return view('battleMenu');
    }
}