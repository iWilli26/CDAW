@extends('template')
@section('content')
<!-- display Profile with update and delete user -->
<div class="card">
    <div class="card-header">
        <h2>Profile</h2>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-sm-4">
                <img src="https://cdn.pixabay.com/photo/2016/08/08/09/17/avatar-1577909_960_720.png" class="img-fluid"
                    alt="image de profil">
            </div>
            <form method="post" action="/updateProfile">
                {{@csrf_field()}}
                <div class="col-sm-8">

                    <div><strong>Pseudo :</strong>
                        <input type="text" class="form-control" name="username" value="{{$user->username}}">
                    </div>
                    <div><strong>Email :</strong>
                        <input type="text" class="form-control" name="email" value="{{$user->email}}">
                    </div>
                    <div><strong>Mot de passe :</strong>
                        <input type="text" class="form-control" name="password">
                    </div>
                    <div><strong>Niveau : </strong> {{$user->level}}</div>
                </div>
                <a style="width:40vw" type="submit" href="/updateProfile" class="btn btn-primary mt-2">Modifier</a>
            </form>
            <a style="width:40vw" type="submit" class="btn btn-danger mt-2">Supprimer</a>
        </div>
    </div>
</div>
@endsection