@extends('template')
@section('content')

<head>
    <title>Liste des pokémons</title>
    <script defer src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.css" />
    <script type="text/javascript" defer charset="utf8" src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.js">
    </script>
    <script defer src="./js/listPokemon.js"></script>
</head>

<body>

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

                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    @foreach ($pokemons as $pokemon)
                    <tr>
                        <td>{{$pokemon->id}}</td>
                        <td><img src=" {{$pokemon->front}}" alt="image du pokemon">
                        </td>
                        <td>{{ucfirst($pokemon->name)}}</td>
                        <td>{{ucfirst(DB::table('energy')->where('id', $pokemon->energy)->first()->name)}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endsection
</body>


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