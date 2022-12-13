function capitalizeFirstLetter(string) {
    return string.charAt(0).toUpperCase() + string.slice(1);
}
async function getPokemonData(pokemon) {
    let response = await fetch("/pokemonName/" + pokemon);
    let data = await response.json();
    return data;
}
$(document).ready(function () {
    const pokemons = {
        fire: ["Chimchar", "Ponyta"],
        water: ["Piplup", "Buizel"],
        grass: ["Turtwig", "Budew"],
        electric: ["Pichu", "Pachirisu", "Shinx"],
        normal: ["Starly", "Bidoof", "Aipom"],
        rock: ["Geodude"],
        fighting: ["Machop", "Riolu"],
    };
    let modal = document.getElementById("infos");
    window.onclick = function (event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    };
    $(".btn").click(function () {
        var energy = $(this).text();
        modal.style.display = "block";
        document.querySelector(".modal-title").innerHTML =
            capitalizeFirstLetter(energy);
        let pokemon = [];
        for (let i = 0; i < pokemons[energy.toLowerCase()].length; i++) {
            getPokemonData(pokemons[energy.toLowerCase()][i]).then((data) => {
                pokemon.push(data);
                document.querySelector(".images").innerHTML = "";
                document.querySelector(".infos").innerHTML = "";
                let html = "";
                for (let i = 0; i < pokemon.length; i++) {
                    html +=
                        '<div class="poke"><img src="' +
                        pokemon[i].front +
                        '" style="width:10vw; height:10vw;">' +
                        "<h4>" +
                        pokemons[energy.toLowerCase()][i] +
                        "</h4>" +
                        "</div>";
                    document.querySelector(".infos").innerHTML = html;
                }
                $(".poke").click(function () {
                    let pokemonId = "";
                    for (let i = 0; i < pokemon.length; i++) {
                        if (
                            $(this).text().toLowerCase() ==
                            pokemon[i].name.toLowerCase()
                        ) {
                            pokemonId = pokemon[i].id;
                            console.log(userId, pokemonId);
                        }
                    }
                    fetch("energyName/" + energy.toLowerCase()).then(
                        (response) => {
                            response.json().then((data) => {
                                let energyId = data.id;
                                console.log(userId, energyId);
                                fetch(`/addEnergy`, {
                                    method: "POST",
                                    headers: {
                                        "X-CSRF-Token": $(
                                            'meta[name="_token"]'
                                        ).attr("content"),
                                    },
                                    body: JSON.stringify({
                                        energyId: energyId,
                                        userId: userId,
                                    }),
                                }).then((response) => {
                                    fetch(`/addPokemon`, {
                                        method: "POST",
                                        headers: {
                                            "X-CSRF-Token": $(
                                                'meta[name="_token"]'
                                            ).attr("content"),
                                        },
                                        body: JSON.stringify({
                                            pokemonId: pokemonId,
                                            userId: userId,
                                        }),
                                    }).then((response) => {
                                        window.location.href = "/profile";
                                    });
                                });
                            });
                        }
                    );
                });
            });
        }
    });
});
