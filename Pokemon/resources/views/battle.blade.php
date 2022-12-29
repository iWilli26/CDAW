@extends('template')
@push('head')
<meta name="_token" content="{{ csrf_token() }}">
<script src="{{ asset('/js/battle.js') }}"></script>
<link rel="stylesheet" href="{{ asset('/css/battle.css')}}">
@endpush
@section('content')
<div class="modal" id="modal" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"></h4>
            </div>
            <div class="modal-body">
                <div style="display: flex;flex-direction:row">
                    <div class="infos"></div>
                    <div class="images"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<div style="display: flex;flex-direction:column">
    <div id="top">
        <div id="log"></div>
        <div id="spriteOpponent">
            Sprite

        </div>
    </div>
    <div id="mid">Attack</div>
    <div id="bot">
        <div id="spriteMe">Sprite</div>
    </div>
</div>
<div id="command">
    <div id="turn"></div>
    <button id="attack" class="btn btn-primary">Attack</button>
    <button id="special" class="btn btn-primary">Special</button>
    <button id="defense" class="btn btn-primary">Defense</button>
</div>
<script>
let me = <?php echo json_encode($me); ?>;
let opponent = <?php echo json_encode($opponent); ?>;
let myPokemon = <?php echo json_encode($myPokemon); ?>;
let opponentPokemon = <?php echo json_encode($opponentPokemon); ?>;
let mode = <?php echo json_encode($mode); ?>;
console.log(me, opponent);
</script>
@endsection