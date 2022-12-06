@extends('template')
@push('head')
<!-- <script src="{{ asset('/js/listPokemon.js') }}"></script> -->
<link rel="stylesheet" href="{{ asset('/css/profile.css')}}">
@endpush
@section('content')
<?php

use Illuminate\Support\Facades\Auth;

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

        use Illuminate\Support\Facades\DB;

        $pokemons = DB::table('PC')->where('user_id', '=', $user->id)->get();
        foreach ($pokemons as $pokemon) {
            $pokemonData = DB::table('pokemon')->where('id', '=', $pokemon->pokemon_id)->first();
            echo '<div class="pokemon">';
            echo '<img src="' . $pokemonData->front . '" alt="pokemon">';
            echo '<div class="infos">';
            echo '<div class="name">' . ucfirst($pokemonData->name) . '</div>';
            echo '<div class="level">Niveau : ' . $pokemon->level . '</div>';
            echo '<div class="form-check">
            <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
            <label class="form-check-label" for="flexCheckDefault">
              Team
            </label>
          </div>';
            echo '</div>';
            echo '</div>';
        }
        ?>
    </div>
</div>
@endsection