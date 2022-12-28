$(document).ready(function () {
    //put piplup hp to 0
    let title = document.getElementsByClassName("modal-title")[0];
    let images = document.getElementsByClassName("images")[0];
    let infos = document.getElementsByClassName("infos")[0];
    let modal = document.getElementById("modal");
    // window.onclick = function (event) {
    //     if (event.target == modal) {
    //         modal.style.display = "none";
    //     }
    // };
    const battle = (id1, id2) => {
        const spriteMe = document.getElementById("spriteMe");
        const spriteOpponent = document.getElementById("spriteOpponent");
        let pokemon1 = myPokemon.filter((pokemon) => pokemon.id == id1)[0];
        let pokemon2 = opponentPokemon.filter(
            (pokemon) => pokemon.id == id2
        )[0];
        spriteMe.innerHTML =
            "<img src='" + pokemon1.data.back + "' alt='image du pokemon'>";
        spriteOpponent.innerHTML =
            "<img src='" + pokemon2.data.front + "' alt='image du pokemon'>";
        while (pokemon1.pv > 0 && pokemon2.pv > 0) {}
    };
    async function chooseYourPokemon(pokemons) {
        modal.style.display = "block";
        images.innerHTML = "";
        title.innerHTML = "Choose your pokemon";
        for (let i = 0; i < pokemons.length; i++) {
            images.innerHTML +=
                "<div id='entity-" +
                pokemons[i].id +
                "' class='pokemonInfos'><img src='" +
                pokemons[i].data.front +
                "' alt='image du pokemon'>" +
                "<div>level : " +
                pokemons[i].level +
                "</div></div>";
        }
        //create a Promise to wait for the user to click on a pokemon
        let promise = new Promise((resolve, reject) => {
            $(".pokemonInfos").on("click", (event) => {
                let id = event.target.parentNode.id.split("-")[1];
                modal.style.display = "none";
                resolve(id);
            });
        });
        let result = await promise;
        return result;
    }
    const init = async () => {
        if (mode == "fullRandom") {
            console.log("hahahahah");
        } else if (mode == "fullManual") {
            let pokemon1 = myPokemon.filter((pokemon) => pokemon.team == 1);
            let pokemon2 = opponentPokemon.filter(
                (pokemon) => pokemon.team == 1
            );
            console.log(pokemon1[0].data);
            if (pokemon1.length == 0 || pokemon2.length == 0) {
                alert("Please select at least a pokemon for each team");
                window.location.href = "/battleMenu";
            }
            const poke1 = await chooseYourPokemon(pokemon1);
            const poke2 = await chooseYourPokemon(pokemon2);
            battle(poke1, poke2);
        } else if (mode == "Mixed") {
            console.log("asd");
        }
    };

    init();
});
