function capitalizeFirstLetter(string) {
    return string.charAt(0).toUpperCase() + string.slice(1);
}
$(document).ready(function () {
    $(".fl-table").DataTable();
    let modal = document.getElementById("infos");
    window.onclick = function (event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    };
    $(".fl-table").on("click", (event) => {
        let id = $(event.target).closest("tr")[0].children[0].innerHTML;
        let energy = $(event.target).closest("tr")[0].children[3].innerHTML;
        fetch("/pokemonId/" + id)
            .then((response) => response.json())
            .then((data) => {
                document.getElementsByClassName("modal-title")[0].innerHTML =
                    capitalizeFirstLetter(data.name);
                document.getElementsByClassName("images")[0].innerHTML =
                    "<img src='" +
                    data.front +
                    "' alt='image du pokemon'>" +
                    "<img src='" +
                    data.back +
                    "' alt='image du pokemon'>";
                document.getElementsByClassName("infos")[0].innerHTML =
                    "<p>Id : " +
                    data.id +
                    "</p>" +
                    "<p>Hp : " +
                    data.pv +
                    "</p>" +
                    "<p>Attack : " +
                    data.attack +
                    "</p>" +
                    "<p>Defense :" +
                    data.defense +
                    "</p>" +
                    "<p>Special attack : " +
                    data.special_attack +
                    "</p>" +
                    "<p>Special Defense : " +
                    data.special_defense +
                    "</p>" +
                    "<p>Speed : " +
                    data.speed +
                    "<p>Energy : " +
                    energy +
                    "</p>";

                modal.style.display = "block";
            });
    });
});
