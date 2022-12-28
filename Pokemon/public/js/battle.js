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
    const levelStats = (pokemon) => {
        pokemon.data.attack = pokemon.data.attack * 0.1 * pokemon.level;
        pokemon.data.pv = pokemon.data.pv * 0.1 * pokemon.level;
        pokemon.data.defense = pokemon.data.defense * 0.1 * pokemon.level;
        pokemon.data.special_attack =
            pokemon.data.special_attack * 0.1 * pokemon.level;
        pokemon.data.special_defense =
            pokemon.data.special_defense * 0.1 * pokemon.level;
        return pokemon;
    };
    const displaySprite = (pokemon1, pokemon2) => {
        const spriteMe = document.getElementById("spriteMe");
        const spriteOpponent = document.getElementById("spriteOpponent");
        spriteMe.innerHTML =
            "<img src='" +
            pokemon1.data.back +
            "' alt='image du pokemon'><div id='me-pv'></div>";
        spriteOpponent.innerHTML =
            "<img src='" +
            pokemon2.data.front +
            "' alt='image du pokemon'><div id='opponent-pv'></div>";
    };
    const updatePV = (pokemon1, pokemon2) => {
        document.getElementById("me-pv").innerHTML = "PV : " + pokemon1.data.pv;
        document.getElementById("opponent-pv").innerHTML =
            "PV : " + pokemon2.data.pv;
    };
    async function moves(pokemon1, pokemon2) {
        let promise = new Promise((resolve, reject) => {
            $("#attack").click(function () {
                pokemon2.data.pv -= pokemon1.data.attack;
                console.log("pokemon1 attack");
                resolve();
            });
            $("#defense").click(function () {
                console.log("pokemon1 defense");
                console.log("what");
                resolve();
            });
            $("#special").click(function () {
                pokemon2.data.pv -= pokemon1.data.special_attack;
                console.log("pokemon1 special-attack");
                resolve();
            });
        });
        let result = await promise;
        return result;
    }
    const battle = async (id1, id2) => {
        let pokemon1 = myPokemon.filter((pokemon) => pokemon.id == id1)[0];
        let pokemon2 = opponentPokemon.filter(
            (pokemon) => pokemon.id == id2
        )[0];
        pokemon1 = levelStats(pokemon1);
        pokemon2 = levelStats(pokemon2);
        console.log(pokemon1);
        displaySprite(pokemon1, pokemon2);
        updatePV(pokemon1, pokemon2);
        //make a turn by turn game battle system where the user has to click on a button to act at each turn and the opponent too
        let turn = 1;
        while (pokemon1.data.pv > 0 && pokemon2.data.pv > 0) {
            if (turn % 2 == 0) {
                await moves(pokemon1, pokemon2);
                console.log("turn " + turn);
            } else {
                await moves(pokemon2, pokemon1);
                console.log("turn " + turn);
            }
            updatePV(pokemon1, pokemon2);
            turn++;
        }
        console.log("end of battle");
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
