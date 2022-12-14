@extends('template')
@push('head')
<script src="{{ asset('/js/battleMenu.js') }}"></script>
<meta name="_token" content="{{ csrf_token() }}">
@endpush
@section('content')
<div style="display: flex;justify-content:space-around; margin:10px">
    <div id="fullRand" style="height: 100px;width:200px" class="btn btn-primary">Mode aléatoire auto
    </div>
    <div id="fullManual" style="height: 100px;width:200px" class="btn btn-primary">Manuel + turn based
    </div>
    <div id="Mixed" style="height: 100px;width:200px" class="btn btn-primary">Mode aléatoire + turn
        based</div>
</div>
<div style="margin: 50px;">
    <label for="opponent-select">Choose an opponent:</label>
    <select style="width: 30vw;" name="opponents" id="opponent-select">
        <?php
        foreach ($users as $user) {
            if ($user->id == $me->id) {
                echo "<option disabled value='$user->id'>$user->username</option>";;
            } else {
                echo "<option value='$user->id'>$user->username</option>";
            }
        }

        ?>
    </select>
</div>
<script>
</script>
@endsection