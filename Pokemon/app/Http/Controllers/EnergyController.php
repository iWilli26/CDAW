<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;
use App\Models\Energy;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class EnergyController extends Controller
{
    public static function getFirstEnergy()
    {
        $user = Auth::user();
        $count = DB::table('pc')->where('user_id', '=', $user->id)->count();
        if ($count == 0) {
            return view('firstEnergy');
        } else {
            return redirect('/battleMenu');
        }
    }
}