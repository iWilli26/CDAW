@extends('template')
@push('head')
<script src="{{ asset('/js/profile.js') }}"></script>
<link rel="stylesheet" href="{{ asset('/css/profile.css')}}">
<meta name="_token" content="{{ csrf_token() }}">
@endpush
@section('content')
<?php

use Illuminate\Support\Facades\Auth;
use App\Models\User;

$user = Auth::user();
?>
<div class="card">
    <div class="card-header">
        <h2>Profile</h2>
    </div>
    <div class="card-body">
        <div class="row">
            @if (session('message'))
            <div class="alert alert-success">
                {{ session('message') }}
            </div>
            @endif

            <form method="post" action="{{ route('editAccount') }}">
                @csrf
                <div class="col-sm-8">
                    <div>
                        <label for="username">{{ __('Pseudo') }}</label>
                        <input type="text" class="form-control" name="username" value="{{$user->username}}">
                        @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div>
                        <label for="email">{{ __('E-Mail Address') }}</label>
                        <input type="text" class="form-control" name="email" value="{{$user->email}}">
                        @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div>
                        <label for="password">{{ __('Password') }}</label>
                        <input type="text" class="form-control" name="password">
                    </div>
                    <div><strong>Niveau : </strong> {{$user->level}}</div>
                    <div><strong>Nombre de pokémons battus : </strong> {{$user->beaten}}</div>
                </div>
                <button type="submit" class="mt-2 btn btn-primary">
                    {{ __('Edit') }}
                </button>
            </form>
            <a style="width:40vw" type="submit" class="btn btn-danger mt-2">Supprimer</a>
        </div>
    </div>
    <div class="myPokemons">
        <?php
        for ($i = 0; $i < count($pokemonPC); $i++) {

            echo '<div class="pokemon">';
            echo '<img src="' . $pokemonData[$i]->front . '" alt="pokemon">';
            echo '<div class="infos">';
            echo '<div class="name">' . ucfirst($pokemonData[$i]->name) . '</div>';
            echo '<div class="level">Niveau : ' . $pokemonPC[$i]->level . '</div>';
            echo '<div class="form-check">
            <div>';
            if ($pokemonPC[$i]->team == 1) {
                echo '<input class="form-check-input teamCheck" type="checkbox" value="" id="flexCheckDefault" checked>';
            } else {
                echo '<input class="form-check-input teamCheck" type="checkbox" value="" id="flexCheckDefault">';
            }
            echo '<div style="display:none">' . $pokemonPC[$i]->id . '</div>';
            echo '<label class="form-check-label" for="flexCheckDefault">
            Team
            </label>
            </div>
            <button class="btn btn-danger btn-sm rounded-5 release" type="button" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fa fa-trash"></i></button>
          ';
            echo '<div style="display:none">' . $pokemonData[$i]->id . '</div>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
        }
        ?>
    </div>

    <div id="history">
        <?php
        for ($i = 0; $i < count($fight); $i++) {
            $pokemonWinner = [$fight[$i]->winner_pokemon_id1, $fight[$i]->winner_pokemon_id2, $fight[$i]->winner_pokemon_id3];
            $pokemonLoser = [$fight[$i]->loser_pokemon_id1, $fight[$i]->loser_pokemon_id2, $fight[$i]->loser_pokemon_id3];
            $winner = User::find($fight[$i]->winner_id)->username;
            $loser = User::find($fight[$i]->loser_id)->username;
            if ($fight[$i]->winner_id == $user->id) {
                echo '<div class="fight winner">';
                echo '<div class="teamInfos">' . $winner;
                echo '<div class="pokemonInfos">';
                foreach ($sprites[$i][0] as $sprite) {
                    echo '<img src="' . $sprite . '" alt="pokemon">';
                }
                echo '</div>';
                echo '</div>';
                echo '<div class="vs">VS</div>';
                echo '<div class="teamInfos">' . $loser;
                echo '<div class="pokemonInfos">';
                foreach ($sprites[$i][1] as $sprite) {
                    echo '<img src="' . $sprite . '" alt="pokemon">';
                }
                echo '</div>';
                echo '</div>';
                echo '</div>';
            } else {
                echo '<div class="fight loser">';
                echo '<div class="teamInfos">' . $loser;
                echo '<div class="pokemonInfos">';
                foreach ($sprites[$i][1] as $sprite) {
                    echo '<img src="' . $sprite . '" alt="pokemon">';
                }
                echo '</div>';
                echo '</div>';
                echo '<div class="vs">VS</div>';
                echo '<div class="teamInfos">' . $winner;
                echo '<div class="pokemonInfos">';
                foreach ($sprites[$i][0] as $sprite) {
                    echo '<img src="' . $sprite . '" alt="pokemon">';
                }
                echo '</div>';
                echo '</div>';
                echo '</div>';
            }
        }
        ?>
    </div>
</div>
<script>
const fight = <?php echo json_encode($fight); ?>;
const sprites = <?php echo json_encode($sprites); ?>;
const userId = <?php echo $user->id ?>;
const pokemonPC = <?php echo json_encode($pokemonPC); ?>;
const pokemonData = <?php echo json_encode($pokemonData); ?>;
</script>
@endsection