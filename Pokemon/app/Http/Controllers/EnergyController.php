<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;
use App\Models\Energy;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class EnergyController extends Controller
{
    public static function getFirstEnergy()
    {
        return view('firstEnergy');
    }
}