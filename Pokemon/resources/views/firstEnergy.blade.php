@extends('template')
@push('head')
<script src="{{ asset('/js/firstEnergy.js') }}"></script>
<link rel="stylesheet" href="{{ asset('/css/firstEnergy.css')}}">
<meta name="_token" content="{{ csrf_token() }}">
@endpush
@section('content')
<div class="header">
    <h1>Bienvenu dans Pokemon</h1>
    <p>Vous pouvez choisir qu'un type de départ, vous aurez ensuite le choix entre un ou plusieurs pokemon du type que
        vous avez choisi</p>
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
</div>
<?php

use Illuminate\Support\Facades\Auth;

$userId = Auth::id();
$pokemons = (object)[
    'fire' => [
        'Chimchar',
        'Ponyta',
    ],
    'water' => [
        'Piplup',
        'Buizel',
    ],
    'grass' => [
        'Turtwig',
        'Budew',
    ],
    'electric' => [
        'Pichu',
        'Pachirisu',
        'Shinx',
    ],
    'normal' => [
        'Starly',
        'Bidoof',
        'Aipom',
    ],
    'fighting' => [
        'Machop',
        'Riolu',
    ],
    'rock' => [
        'Geodude',
    ],
];
echo '<div style="display:flex; flex-wrap:wrap; align-items:center; position:relative">';
foreach ($pokemons as $energy => $pokemon) {
    echo '<button class="btn btn-primary m-5" style="width:10vw">' . ucfirst($energy) . '</button>';
}
echo '</div>';




?>
<script>
const userId = <?php echo $userId ?>;
</script>
@endsection