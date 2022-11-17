@extends('template')
@section('content')
<?php

use \App\Http\Controllers\listePokemonsController; {
    $test = listePokemonsController::getLotPokemon();
}

?>
<div>
    <h1>Liste des pokémons</h1>

    <form action="/search" method="POST" role="search">
        <div class="input-group">
            <input type="text" class="form-control" name="q" placeholder="Search users"> <span class="input-group-btn">
                <button type="submit" class="btn btn-default">
                    <span class="glyphicon glyphicon-search"></span>
                </button>
            </span>
        </div>
    </form>
    <ul>
        @foreach ($test->results as $pokemon)
        <li>
            <div>
                {{ $pokemon->name }}
            </div>
        </li>
        @endforeach
    </ul>
</div>
@endsection