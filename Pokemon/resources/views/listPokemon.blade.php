@extends('template')
@section('content')
<?php
?>
<div>
    <h1>Liste des pokémons</h1>
    <div class="table-wrapper">
        <table class="fl-table">
            <tr>
                <th>Id</th>
                <th>Sprite</th>
                <th>Name</th>
                <th>Énergie</th>
            </tr>
            @foreach ($pokemons as $pokemon)
            <tr>
                <td>{{$pokemon->pokemon_id}}</td>
                <td><img src=" {{$pokemon->image}}" alt="image du pokemon">
                </td>
                <td>{{ucfirst($pokemon->name)}}</td>
                <td>{{ucfirst(DB::table('energy')->where('energy_id', $pokemon->energy)->first()->name)}}</td>
            </tr>
            @endforeach
        </table>
    </div>
</div>
@endsection
<style scoped>
.table-wrapper {
    margin: 0vw 5vw 5vw;
    box-shadow: 0px 35px 50px rgba(0, 0, 0, 0.2);
}

h1 {
    text-align: center;
}

.fl-table {
    border-radius: 5px;
    font-size: 12px;
    font-weight: normal;
    border: none;
    border-collapse: collapse;
    width: 90vw;
    white-space: nowrap;
    background-color: white;
}

.fl-table td,
.fl-table th {
    text-align: center;
    padding: 8px;
}

.fl-table td {
    border-right: 1px solid #f8f8f8;
    font-size: 12px;
}

.fl-table thead th {
    color: #ffffff;
    background: #4FC3A1;
}


.fl-table thead th:nth-child(odd) {
    color: #ffffff;
    background: #324960;
}

.fl-table tr:nth-child(even) {
    background: #F8F8F8;
}
</style>