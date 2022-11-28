@extends('template')

<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.css">
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.js">
    </script>


</head>
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
                    <td>{{ucfirst(DB::table('energy')->where('id', $pokemon->energy)->first()->name)}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
<script>
function capitalizeFirstLetter(string) {
    return string.charAt(0).toUpperCase() + string.slice(1);
}
$(document).ready(function() {
    $('.fl-table').DataTable();
    let modal = document.getElementById("infos");
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
    $('.fl-table').on("click", (event) => {
        let id = $(event.target).closest("tr")[0].children[0].innerHTML;
        let energy = $(event.target).closest("tr")[0].children[3].innerHTML;
        fetch('/pokemon/' + id)
            .then(response => response.json())
            .then(data => {
                document.getElementsByClassName("modal-title")[0].innerHTML =
                    capitalizeFirstLetter(data
                        .name);
                document.getElementsByClassName("images")[0].innerHTML = "<img src='" + data
                    .front + "' alt='image du pokemon'>" + "<img src='" + data.back +
                    "' alt='image du pokemon'>";
                document.getElementsByClassName("infos")[0].innerHTML = "<p>Id : " + data
                    .id + "</p>" + "<p>Hp : " + data.pv_max + "</p>" + "<p>Attack : " + data
                    .normal_attack + "</p>" + "<p>Special attack : " + data.special_attack +
                    "</p>" + "<p>Special Defense : " + data.special_defense + "</p>" +
                    "<p>Energy : " + energy + "</p>";

                modal.style.display = 'block';
            })


    });
});
</script>


<style scoped>
.infos {
    font-size: 1rem;
    display: flex;
    flex-direction: column;
    justify-content: space-around;
}

.images img {
    width: 100px;
    height: 100px;
    margin: 10px;
}

.images {
    display: flex;
    flex-direction: column;
    justify-content: space-around;
}

.pokemon {
    cursor: pointer;
    transition: 0.5s;

}

/* get bigger on hover */
.pokemon:hover {
    transform: scale(1.1);
}

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