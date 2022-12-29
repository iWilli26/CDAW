$(document).ready(function () {
    //put piplup hp to 0
    let title = document.getElementsByClassName("modal-title")[0];
    let images = document.getElementsByClassName("images")[0];
    let infos = document.getElementsByClassName("infos")[0];
    let modal = document.getElementById("modal");
    let log = document.getElementById("log");
    const spriteMe = document.getElementById("spriteMe");
    const spriteOpponent = document.getElementById("spriteOpponent");
    function capitalizeFirstLetter(string) {
        return string.charAt(0).toUpperCase() + string.slice(1);
    }
    const levelStats = (pokemon) => {
        pokemon.data.attack = ~~(
            pokemon.data.attack +
            pokemon.data.attack * 0.1 * pokemon.level
        );
        pokemon.data.special_attack = ~~(
            pokemon.data.special_attack +
            pokemon.data.special_attack * 0.1 * pokemon.level
        );
        pokemon.data.pv = ~~(
            pokemon.data.pv +
            pokemon.data.pv * 0.1 * pokemon.level
        );
        pokemon.data.defense = ~~(
            pokemon.data.defense +
            pokemon.data.defense * 0.1 * pokemon.level
        );
        pokemon.data.special_defense = ~~(
            pokemon.data.special_defense +
            pokemon.data.special_defense * 0.1 * pokemon.level
        );
        pokemon.data.speed = ~~(
            pokemon.data.speed +
            pokemon.data.speed * 0.1 * pokemon.level
        );
        return pokemon;
    };
    const displaySprite = (pokemon1, pokemon2) => {
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
    async function moves(pokemonTurn, pokemonNot) {
        let promise = new Promise((resolve, reject) => {
            $("#attack").click(function () {
                log.innerHTML +=
                    capitalizeFirstLetter(pokemonTurn.data.name) +
                    " attaque<br>";
                log.innerHTML +=
                    capitalizeFirstLetter(pokemonNot.data.name) +
                    " perd " +
                    pokemonTurn.data.attack +
                    " PV<br>";
                pokemonNot.data.pv -= pokemonTurn.data.attack;
                resolve();
            });
            $("#defense").click(function () {
                //Je ne savais pas quoi faire avec ça
                resolve();
            });
            $("#special").click(function () {
                log.innerHTML +=
                    capitalizeFirstLetter(pokemonTurn.data.name) +
                    " attaque spécial<br>";
                log.innerHTML +=
                    capitalizeFirstLetter(pokemonNot.data.name) +
                    " perd " +
                    pokemonTurn.data.special_attack +
                    " PV<br>";
                pokemonNot.data.pv -= pokemonTurn.data.special_attack;
                resolve();
            });
        });
        let result = await promise;
        $("#attack").off("click");
        $("#defense").off("click");
        $("#special").off("click");
        return result;
    }
    const battle = async (id1, id2) => {
        let pokemon1 = myPokemon.find((pokemon) => pokemon.id == id1);
        let pokemon2 = opponentPokemon.find((pokemon) => pokemon.id == id2);
        displaySprite(pokemon1, pokemon2);
        updatePV(pokemon1, pokemon2);
        let turn = 1;
        while (pokemon1.data.pv > 0 && pokemon2.data.pv > 0) {
            if (turn % 2 == 0) {
                log.innerHTML +=
                    "C'est le tour " +
                    turn +
                    "au tour de " +
                    me.username +
                    "<br>";
                await moves(pokemon1, pokemon2);
            } else {
                log.innerHTML +=
                    "C'est le tour " +
                    turn +
                    " au tour de " +
                    opponent.username +
                    "<br>";
                await moves(pokemon2, pokemon1);
            }
            updatePV(pokemon1, pokemon2);
            turn++;
            log.scrollTo(0, log.scrollHeight);
        }
        if (pokemon1.data.pv <= 0) {
            log.innerHTML +=
                capitalizeFirstLetter(pokemon1.data.name) + " est KO<br>";
            log.innerHTML +=
                capitalizeFirstLetter(pokemon2.data.name) + " gagne<br>";
            spriteMe.classList.add("dead");
            //remove the dead pokemon from the array
            myPokemon = myPokemon.filter((pokemon) => pokemon.id != id1);
            if (myPokemon.length == 0) {
                alert("Vous avez perdu");
                return;
            }
            spriteMe.classList.remove("dead");
            const idnext = await chooseYourPokemon(myPokemon, me.username);
            battle(idnext, id2);
        } else {
            log.innerHTML +=
                capitalizeFirstLetter(pokemon2.data.name) + " est KO<br>";
            log.innerHTML +=
                capitalizeFirstLetter(pokemon1.data.name) + " gagne<br>";
            spriteOpponent.classList.add("dead");
            //remove the dead pokemon from the array
            opponentPokemon = opponentPokemon.filter(
                (pokemon) => pokemon.id != id2
            );
            if (opponentPokemon.length == 0) {
                alert("Vous avez perdu");
                return;
            }
            spriteOpponent.classList.remove("dead");
            const idnext = await chooseYourPokemon(
                opponentPokemon,
                opponent.username
            );
            battle(id1, idnext);
        }
    };
    async function chooseYourPokemon(pokemons, username) {
        modal.style.display = "block";
        images.innerHTML = "";
        title.innerHTML = username + " : Choose your pokemon";
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
        for (let i = 0; i < myPokemon.length; i++) {
            levelStats(myPokemon[i]);
        }
        for (let i = 0; i < opponentPokemon.length; i++) {
            levelStats(opponentPokemon[i]);
        }
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

            const poke1 = await chooseYourPokemon(pokemon1, me.username);
            const poke2 = await chooseYourPokemon(pokemon2, opponent.username);
            battle(poke1, poke2);
        } else if (mode == "Mixed") {
            console.log("asd");
        }
    };

    init();
});
