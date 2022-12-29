$(document).ready(function () {
    //put piplup hp to 0
    let title = document.getElementsByClassName("modal-title")[0];
    let images = document.getElementsByClassName("images")[0];
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
                pokemonNot.data.pv -=
                    pokemonTurn.data.attack - pokemonNot.data.defense / 2;
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
                pokemonNot.data.pv -=
                    pokemonTurn.data.special_attack -
                    pokemonNot.data.special_defense / 2;
                resolve();
            });
        });
        let result = await promise;
        $("#attack").off("click");
        $("#defense").off("click");
        $("#special").off("click");
        return result;
    }
    async function movesAuto(pokemon1, pokemon2, turn) {
        let promise = new Promise((resolve, reject) => {
            $(body).click(function () {
                if (turn % 4 === 0) {
                    log.innerHTML +=
                        capitalizeFirstLetter(pokemon1.data.name) +
                        " attaque<br>";
                    log.innerHTML +=
                        capitalizeFirstLetter(pokemon2.data.name) +
                        " perd " +
                        pokemon1.data.attack +
                        " PV<br>";
                    pokemon2.data.pv -=
                        pokemon1.data.attack - pokemon2.data.defense / 2;
                }
            });
        });
        let result = await promise;
        return result;
    }
    const battleManual = async (id1, id2, mode) => {
        let pokemon1 = myPokemon.find((pokemon) => pokemon.id == id1);
        let pokemon2 = opponentPokemon.find((pokemon) => pokemon.id == id2);
        displaySprite(pokemon1, pokemon2);
        updatePV(pokemon1, pokemon2);
        let pokeAttack = false;
        let turn = 0;
        if (pokemon1.data.speed > pokemon2.data.speed) {
            pokeAttack = true;
        } else if (pokemon1.data.speed === pokemon2.data.speed) {
            pokeAttack = Math.random() >= 0.5;
        }
        while (pokemon1.data.pv > 0 && pokemon2.data.pv > 0) {
            console.log(pokemon1, pokemon2);
            if (pokeAttack) {
                log.innerHTML +=
                    "C'est le tour " +
                    turn +
                    "au tour de " +
                    me.username +
                    "<br>";
                await moves(pokemon1, pokemon2);
                pokeAttack = false;
            } else {
                log.innerHTML +=
                    "C'est le tour " +
                    turn +
                    " au tour de " +
                    opponent.username +
                    "<br>";
                await moves(pokemon2, pokemon1);
                pokeAttack = true;
            }
            updatePV(pokemon1, pokemon2);
            turn++;
            log.scrollTo(0, log.scrollHeight);
        }
        if (pokemon1.data.pv <= 0) {
            fetch("http://localhost:8000/addLevel/" + opponent.id, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-Token": $('meta[name="_token"]').attr("content"),
                },
            });
            fetch("http://localhost:8000/addLevelPokemon/" + pokemon2.id, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-Token": $('meta[name="_token"]').attr("content"),
                },
            });
            fetch(`/addEnergy`, {
                method: "POST",
                headers: {
                    "X-CSRF-Token": $('meta[name="_token"]').attr("content"),
                },
                body: JSON.stringify({
                    energyId: pokemon1.data.energy_id,
                    userId: opponent.id,
                }),
            });
            log.innerHTML +=
                capitalizeFirstLetter(pokemon1.data.name) + " est KO<br>";
            log.innerHTML +=
                capitalizeFirstLetter(pokemon2.data.name) + " gagne<br>";
            spriteMe.classList.add("dead");
            myPokemon = myPokemon.filter((pokemon) => pokemon.id != id1);
            if (myPokemon.length == 0) {
                fetch("http://localhost:8000/addFight/", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-Token": $('meta[name="_token"]').attr(
                            "content"
                        ),
                    },
                    body: JSON.stringify({
                        winner: opponent.id,
                        loser: me.id,
                    }),
                });
                alert(me.username + " a perdu");
                return;
            }
            spriteMe.classList.remove("dead");
            if (mode == "Manual") {
                const idnext = await chooseYourPokemon(myPokemon, me.username);
                battleManual(idnext, id2, "Manual");
            } else if (mode == "Mixed") {
                //choose a random pokemon
                const idnext =
                    myPokemon[~~(Math.random() * myPokemon.length)].id;
                battleManual(idnext, id2, "Mixed");
            }
        } else {
            fetch("http://localhost:8000/addLevel/" + me.id, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-Token": $('meta[name="_token"]').attr("content"),
                },
            });
            fetch("http://localhost:8000/addLevelPokemon/" + pokemon1.id, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-Token": $('meta[name="_token"]').attr("content"),
                },
            });
            fetch(`/addEnergy`, {
                method: "POST",
                headers: {
                    "X-CSRF-Token": $('meta[name="_token"]').attr("content"),
                },
                body: JSON.stringify({
                    energyId: pokemon2.data.energy_id,
                    userId: me.id,
                }),
            });
            log.innerHTML +=
                capitalizeFirstLetter(pokemon2.data.name) + " est KO<br>";
            log.innerHTML +=
                capitalizeFirstLetter(pokemon1.data.name) + " gagne<br>";
            spriteOpponent.classList.add("dead");
            opponentPokemon = opponentPokemon.filter(
                (pokemon) => pokemon.id != id2
            );
            if (opponentPokemon.length == 0) {
                alert(opponent.username + " a perdu");
                fetch("http://localhost:8000/addFight/", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-Token": $('meta[name="_token"]').attr(
                            "content"
                        ),
                    },
                    body: JSON.stringify({
                        winner: me.id,
                        loser: opponent.id,
                    }),
                });
                return;
            }
            spriteOpponent.classList.remove("dead");
            if (mode == "Manual") {
                const idnext = await chooseYourPokemon(
                    opponentPokemon,
                    opponent.username
                );
                battleManual(id1, idnext, "Manual");
            } else if (mode == "Mixed") {
                const idnext =
                    opponentPokemon[~~(Math.random() * opponentPokemon.length)]
                        .id;
                battleManual(id1, idnext, "Mixed");
            }
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
            battleManual(poke1, poke2);
        } else if (mode == "Mixed") {
            let pokemon1 = myPokemon.filter((pokemon) => pokemon.team == 1);
            let pokemon2 = opponentPokemon.filter(
                (pokemon) => pokemon.team == 1
            );
            if (pokemon1.length == 0 || pokemon2.length == 0) {
                alert("Please select at least a pokemon for each team");
                window.location.href = "/battleMenu";
            }
            const poke1 =
                pokemon1[Math.floor(Math.random() * pokemon1.length)].id;
            const poke2 =
                pokemon2[Math.floor(Math.random() * pokemon2.length)].id;
            battleManual(poke1, poke2, "Mixed");
        }
    };

    init();
});
