@extends('template')
@section('content')
<!-- Register account form -->
<div class="card">
    <div class="card-header">
        <h2>Register</h2>
    </div>
    <div class="card-body">
        <form method="post" action="/register">
            {{@csrf_field()}}
            <div class="row">
                <div class="col-sm-4">
                    <img src="https://cdn.pixabay.com/photo/2016/08/08/09/17/avatar-1577909_960_720.png"
                        class="img-fluid" alt="image de profil">
                </div>
                <div class="col-sm-8">
                    <div><strong>Pseudo :</strong>
                        <input type="text" class="form-control" name="username">
                    </div>
                    <div><strong>Email :</strong>
                        <input type="text" class="form-control" name="email">
                    </div>
                    <div><strong>Mot de passe :</strong>
                        <input type="text" class="form-control" name="password">
                    </div>
                </div>
                <a style="width:40vw" type="submit" href="/register" class="btn btn-primary mt-2">Register</a>
            </div>
        </form>
    </div>
</div>
@endsection