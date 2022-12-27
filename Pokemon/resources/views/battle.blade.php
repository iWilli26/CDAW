@extends('template')
@push('head')
<meta name="_token" content="{{ csrf_token() }}">
<script src="{{ asset('/js/battle.js') }}"></script>
<link rel="stylesheet" href="{{ asset('/css/battle.css')}}">
@endpush
@section('content')
<div style="display: flex;flex-direction:column">
    <div id="top">
        <div id="log">log</div>
        <div id="spriteOpp">Sprite</div>
    </div>
    <div id="mid">Attack</div>
    <div id="bot">
        <div id="spriteMe">Sprite</div>
        <div id="as">jsp</div>
    </div>
</div>
<div>

    <?php
    echo $mode;
    foreach ($myPokemon as $pokemon) {
        echo $pokemon;
        echo "<br>";
    }
    echo "<br>";
    echo "<br>";
    foreach ($opponentPokemon as $pokemon) {
        echo $pokemon;
        echo "<br>";
    }
    ?>
</div>
<script>
let me = <?php echo json_encode($me); ?>;
let opponent = <?php echo json_encode($opponent); ?>;
let myPokemon = <?php echo json_encode($myPokemon); ?>;
let opponentPokemon = <?php echo json_encode($opponentPokemon); ?>;
let mode = <?php echo json_encode($mode); ?>;
</script>
@endsection