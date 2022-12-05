@extends('template')
@push('head')
<script src="{{ asset('/js/listPokemon.js') }}"></script>
<link rel="stylesheet" href="{{ asset('/css/listPokemon.css')}}">
@endpush
@section('content')
<div>
    <h1>Liste des pokémons</h1>
    <div class="table-wrapper">
        <table class="fl-table">
            <thead>

                <tr>
                    <th>Id</th>
                    <th>Sprite</th>
                    <th>Name</th>
                    <th>Énergie</th>
                </tr>
            </thead>
            <tbody>
                <div class="modal" id="infos" style="display: none;">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title"></h4>
                            </div>
                            <div class="modal-body">
                                <div style="display: flex;flex-direction:row">
                                    <div class="images"></div>
                                    <div class="infos"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                @foreach ($pokemons as $pokemon)
                <tr class="pokemon">
                    <td>{{$pokemon->id}}</td>
                    <td><img src=" {{$pokemon->front}}" alt="image du pokemon">
                    </td>
                    <td>{{ucfirst($pokemon->name)}}</td>
                    <td>{{ucfirst(DB::table('energy')->where('id', $pokemon->energy_id)->first()->name)}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection