$(document).ready(function () {
    //table des types pokemon et leurs multiplicateurs de dégats
    //1 : normal
    //2 : fighting
    //3 : flying
    //4 : poison
    //5 : ground
    //6 : rock
    //7 : bug
    //8 : ghost
    //9 : steel
    //10 : fire
    //11 : water
    //12 : grass
    //13 : electric
    //14 : psychic
    //15 : ice
    //16 : dragon
    //17 : dark
    //18 : fairy
    const types = [
        [1, 1, 1, 1, 1, 0.5, 1, 0, 0.5, 1, 1, 1, 1, 1, 1, 1, 1, 1],
        [2, 1, 0.5, 0.5, 1, 2, 0.5, 0, 2, 1, 1, 1, 1, 0.5, 2, 1, 2, 0.5],
        [1, 2, 1, 1, 1, 0.5, 2, 1, 0.5, 1, 1, 2, 0.5, 1, 1, 1, 1, 1],
        [1, 1, 1, 0.5, 0.5, 0.5, 1, 0.5, 0, 1, 1, 2, 1, 1, 1, 1, 1, 2],
        [1, 1, 0, 2, 1, 2, 0.5, 1, 2, 2, 1, 0.5, 2, 1, 1, 1, 1, 1],
        [1, 0.5, 2, 1, 0.5, 1, 2, 1, 0.5, 2, 1, 1, 1, 1, 2, 1, 1, 1],
        [1, 0.5, 0.5, 0.5, 1, 1, 1, 0.5, 0.5, 0.5, 1, 2, 1, 2, 1, 1, 2, 0.5],
        [0, 0, 1, 1, 1, 1, 1, 2, 1, 1, 1, 1, 1, 2, 1, 1, 0.5, 1],
        [1, 1, 1, 1, 1, 2, 1, 1, 0.5, 0.5, 0.5, 1, 0.5, 1, 2, 1, 1, 2],
        [1, 1, 1, 1, 1, 0.5, 2, 1, 2, 0.5, 0.5, 2, 1, 1, 2, 0.5, 1, 1],
        [1, 1, 1, 1, 2, 2, 1, 1, 1, 2, 0.5, 0.5, 1, 1, 1, 0.5, 1, 1],
        [1, 1, 0.5, 0.5, 2, 2, 0.5, 1, 0.5, 0.5, 2, 0.5, 1, 1, 1, 0.5, 1, 1],
        [1, 1, 2, 1, 0, 1, 1, 1, 1, 1, 2, 0.5, 0.5, 1, 1, 0.5, 1, 1],
        [1, 2, 1, 2, 1, 1, 1, 1, 0.5, 1, 1, 1, 1, 0.5, 1, 1, 0, 1],
        [1, 1, 2, 1, 2, 1, 1, 1, 0.5, 0.5, 0.5, 2, 1, 1, 0.5, 2, 1, 1],
        [1, 1, 1, 1, 1, 1, 1, 1, 0.5, 1, 0.5, 0.5, 0.5, 1, 2, 2, 1, 0],
        [1, 0.5, 1, 1, 1, 1, 1, 2, 1, 1, 1, 1, 1, 2, 1, 1, 0.5, 0.5],
        [1, 2, 1, 0.5, 1, 1, 1, 1, 0.5, 1, 1, 1, 1, 1, 1, 2, 2, 1],
    ];

    myPokemon = myPokemon.filter((pokemon) => pokemon.team == 1);
    opponentPokemon = opponentPokemon.filter((pokemon) => pokemon.team == 1);
    let title = document.getElementsByClassName("modal-title")[0];
    let images = document.getElementsByClassName("images")[0];
    let modal = document.getElementById("modal");
    let log = document.getElementById("log");
    const spriteMe = document.getElementById("spriteMe");
    const spriteOpponent = document.getElementById("spriteOpponent");
    let pokemonTeam1 = [];
    let pokemonTeam2 = [];
    //fonctino qui permet de mettre la première lettre en majuscule
    function capitalizeFirstLetter(string) {
        return string.charAt(0).toUpperCase() + string.slice(1);
    }

    //Change les stats du pokemon en fonction de son niveau
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
        pokemon.data.pv_max = pokemon.data.pv;
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

    //Place le sprite du pokemon
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

    //Mets à jour les pv du pokemon
    const updatePV = (pokemon1, pokemon2) => {
        document.getElementById("health1").value = `${pokemon1.data.pv}`;
        document.getElementById("health2").value = `${pokemon2.data.pv}`;
    };

    //Choix de l'action du joueur
    async function moves(pokemonTurn, pokemonNot) {
        let promise = new Promise((resolve, reject) => {
            $("#attack").click(function () {
                let damage =
                    (pokemonTurn.data.attack - pokemonNot.data.defense / 2) *
                    types[pokemonTurn.data.energy_id][
                        pokemonNot.data.energy_id
                    ];
                damage < 0 ? (damage = 0) : damage;
                log.innerHTML +=
                    capitalizeFirstLetter(pokemonTurn.data.name) +
                    " attaque<br>";
                log.innerHTML +=
                    capitalizeFirstLetter(pokemonNot.data.name) +
                    " perd " +
                    damage +
                    " PV<br>";
                pokemonNot.data.pv -= damage;
                resolve();
            });
            $("#defense").click(function () {
                resolve();
            });
            $("#special").click(function () {
                let damage =
                    (pokemonTurn.data.special_attack -
                        pokemonNot.data.special_defense / 2) *
                    types[pokemonTurn.data.energy_id][
                        pokemonNot.data.energy_id
                    ];
                damage < 0 ? (damage = 0) : damage;
                log.innerHTML +=
                    capitalizeFirstLetter(pokemonTurn.data.name) +
                    " attaque<br>";
                log.innerHTML +=
                    capitalizeFirstLetter(pokemonNot.data.name) +
                    " perd " +
                    damage +
                    " PV<br>";
                pokemonNot.data.pv -= damage;
                resolve();
            });
        });
        let result = await promise;
        $("#attack").off("click");
        $("#defense").off("click");
        $("#special").off("click");
        return result;
    }

    //Lance l'attaque automatique du pokemon onclick
    async function movesAuto(pokemon1, pokemon2, atk) {
        let promise = new Promise((resolve, reject) => {
            $("body").click(function () {
                if (!atk) {
                    let damage =
                        (pokemon1.data.attack - pokemon2.data.defense / 2) *
                        types[pokemon1.data.energy_id][pokemon2.data.energy_id];
                    damage < 0 ? (damage = 0) : damage;
                    log.innerHTML +=
                        capitalizeFirstLetter(pokemon1.data.name) +
                        " attaque<br>";
                    log.innerHTML +=
                        capitalizeFirstLetter(pokemon2.data.name) +
                        " perd " +
                        damage +
                        " PV<br>";
                    pokemon2.data.pv -= damage;
                    $("body").off("click");
                    resolve();
                } else {
                    let damage =
                        (pokemon1.data.special_attack -
                            pokemon2.data.special_defense / 2) *
                        types[pokemon1.data.energy_id][pokemon2.data.energy_id];
                    damage < 0 ? (damage = 0) : damage;
                    log.innerHTML +=
                        capitalizeFirstLetter(pokemon1.data.name) +
                        " spécial attaque<br>";
                    log.innerHTML +=
                        capitalizeFirstLetter(pokemon2.data.name) +
                        " perd " +
                        damage +
                        " PV<br>";
                    pokemon2.data.pv -= damage;
                    $("body").off("click");
                    resolve();
                }
            });
        });
        let result = await promise;
        return result;
    }

    //Fonction de combat
    const battle = async (id1, id2, mode) => {
        let pokemon1 = myPokemon.find((pokemon) => pokemon.id == id1);
        let pokemon2 = opponentPokemon.find((pokemon) => pokemon.id == id2);
        displaySprite(pokemon1, pokemon2);

        //Barre de vie des pokemons
        document.getElementById(
            "me-pv"
        ).innerHTML = `<progress id="health1" value="${pokemon1.data.pv}" max="${pokemon1.data.pv_max}"></progress>`;
        document.getElementById(
            "opponent-pv"
        ).innerHTML = `<progress id="health2" value="${pokemon2.data.pv}" max="${pokemon2.data.pv_max}"></progress>`;
        updatePV(pokemon1, pokemon2);
        let pokeAttack = false;
        let turn = 0;

        //Détermine qui attaque en premier en fonction de la stat de vitesse
        if (pokemon1.data.speed > pokemon2.data.speed) {
            pokeAttack = true;
        } else if (pokemon1.data.speed === pokemon2.data.speed) {
            pokeAttack = Math.random() >= 0.5;
        }
        let atk1 = false;
        let atk2 = false;

        //Boucle de combat
        while (pokemon1.data.pv > 0 && pokemon2.data.pv > 0) {
            if (pokeAttack) {
                pokeAttack = false;
                log.innerHTML +=
                    "C'est le tour " +
                    turn +
                    "au tour de " +
                    me.username +
                    "<br>";
                if (mode === "fullManual" || mode === "Mixed") {
                    await moves(pokemon1, pokemon2);
                } else if (mode === "fullRandom") {
                    await movesAuto(pokemon1, pokemon2, atk1);
                }
                atk1 = true;
            } else {
                pokeAttack = true;
                log.innerHTML +=
                    "C'est le tour " +
                    turn +
                    " au tour de " +
                    opponent.username +
                    "<br>";
                if (mode === "fullManual" || mode === "Mixed") {
                    await moves(pokemon2, pokemon1);
                } else if (mode === "fullRandom") {
                    await movesAuto(pokemon2, pokemon1, atk2);
                }
                atk2 = true;
            }
            updatePV(pokemon1, pokemon2);
            turn++;
            log.scrollTo(0, log.scrollHeight);
        }

        //Vérifie si un des pokemons est KO
        if (pokemon1.data.pv <= 0) {
            fetch("/addLevel/" + opponent.id + "/", {
                method: "POST",
                headers: {
                    "X-CSRF-Token": $('meta[name="_token"]').attr("content"),
                },
            });
            fetch("/addLevelPokemon/" + pokemon2.id + "/", {
                method: "POST",
                headers: {
                    "X-CSRF-Token": $('meta[name="_token"]').attr("content"),
                },
            });
            fetch("/addEnergy/", {
                method: "POST",
                headers: {
                    "X-CSRF-Token": $('meta[name="_token"]').attr("content"),
                },
                body: JSON.stringify({
                    energyId: pokemon1.data.energy_id,
                    userId: opponent.id,
                }),
            });
            fetch("/addBeaten/" + opponent.id + "/", {
                method: "POST",
                headers: {
                    "X-CSRF-Token": $('meta[name="_token"]').attr("content"),
                },
            });
            log.innerHTML +=
                capitalizeFirstLetter(pokemon1.data.name) + " est KO<br>";
            log.innerHTML +=
                capitalizeFirstLetter(pokemon2.data.name) + " gagne<br>";
            spriteMe.classList.add("dead");
            myPokemon = myPokemon.filter((pokemon) => pokemon.id != id1);
            if (myPokemon.length == 0) {
                fetch("/addFight/", {
                    method: "POST",
                    headers: {
                        "X-CSRF-Token": $('meta[name="_token"]').attr(
                            "content"
                        ),
                    },
                    body: JSON.stringify({
                        winner: opponent.id,
                        loser: me.id,
                        pokemonWinner: pokemonTeam2,
                        pokemonLoser: pokemonTeam1,
                    }),
                });
                alert(me.username + " a perdu");
                return;
            }
            spriteMe.classList.remove("dead");

            //Choix du prochain pokemon ou aléatoire en fonction du mode
            if (mode == "fullManual") {
                const idnext = await chooseYourPokemon(myPokemon, me.username);
                battle(idnext, id2, "fullManual");
            } else if (mode == "Mixed") {
                const idnext =
                    myPokemon[~~(Math.random() * myPokemon.length)].id;
                battle(idnext, id2, "Mixed");
            } else if (mode == "fullRandom") {
                const idnext =
                    myPokemon[~~(Math.random() * myPokemon.length)].id;
                battle(idnext, id2, "fullRandom");
            }
        } else {
            fetch("/addLevel/" + me.id, {
                method: "POST",
                headers: {
                    "X-CSRF-Token": $('meta[name="_token"]').attr("content"),
                },
            });
            fetch("/addLevelPokemon/" + pokemon1.id, {
                method: "POST",
                headers: {
                    "X-CSRF-Token": $('meta[name="_token"]').attr("content"),
                },
            });
            fetch("/addEnergy/", {
                method: "POST",
                headers: {
                    "X-CSRF-Token": $('meta[name="_token"]').attr("content"),
                },
                body: JSON.stringify({
                    energyId: pokemon2.data.energy_id,
                    userId: me.id,
                }),
            });
            fetch("/addBeaten/" + me.id + "/", {
                method: "POST",
                headers: {
                    "X-CSRF-Token": $('meta[name="_token"]').attr("content"),
                },
            });
            log.innerHTML +=
                capitalizeFirstLetter(pokemon2.data.name) + " est KO<br>";
            log.innerHTML +=
                capitalizeFirstLetter(pokemon1.data.name) + " gagne<br>";
            spriteOpponent.classList.add("dead");
            opponentPokemon = opponentPokemon.filter(
                (pokemon) => pokemon.id != id2
            );
            //Vérifie si l'adversaire a encore des pokemons
            if (opponentPokemon.length == 0) {
                alert(opponent.username + " a perdu");
                fetch("/addFight/", {
                    method: "POST",
                    headers: {
                        "X-CSRF-Token": $('meta[name="_token"]').attr(
                            "content"
                        ),
                    },
                    body: JSON.stringify({
                        winner: me.id,
                        loser: opponent.id,
                        pokemonWinner: pokemonTeam1,
                        pokemonLoser: pokemonTeam2,
                    }),
                });
                return;
            }
            spriteOpponent.classList.remove("dead");
            if (mode == "fullManual") {
                const idnext = await chooseYourPokemon(
                    opponentPokemon,
                    opponent.username
                );
                battle(id1, idnext, "fullManual");
            } else if (mode == "Mixed") {
                const idnext =
                    opponentPokemon[~~(Math.random() * opponentPokemon.length)]
                        .id;
                battle(id1, idnext, "Mixed");
            } else if (mode == "fullRandom") {
                const idnext =
                    opponentPokemon[~~(Math.random() * opponentPokemon.length)]
                        .id;
                battle(id1, idnext, "fullRandom");
            }
        }
    };

    //Fonction qui permet de choisir son pokemon
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

    //Initialisation de la bataille
    const init = async () => {
        for (let i = 0; i < myPokemon.length; i++) {
            levelStats(myPokemon[i]);
        }
        for (let i = 0; i < opponentPokemon.length; i++) {
            levelStats(opponentPokemon[i]);
        }
        let pokemon1 = myPokemon.filter((pokemon) => pokemon.team == 1);
        let pokemon2 = opponentPokemon.filter((pokemon) => pokemon.team == 1);
        pokemonTeam1 = pokemon1.map((pokemon) => pokemon.id);
        pokemonTeam2 = pokemon2.map((pokemon) => pokemon.id);
        if (pokemon1.length == 0 || pokemon2.length == 0) {
            alert("Please select at least a pokemon for each team");
            window.location.href = "/battleMenu";
        }
        if (mode == "fullRandom") {
            let id1 = myPokemon[~~(Math.random() * myPokemon.length)].id;
            let id2 =
                opponentPokemon[~~(Math.random() * opponentPokemon.length)].id;
            document.getElementById("command").style.display = "none";
            battle(id1, id2, "fullRandom");
        } else if (mode == "fullManual") {
            const poke1 = await chooseYourPokemon(pokemon1, me.username);
            const poke2 = await chooseYourPokemon(pokemon2, opponent.username);
            battle(poke1, poke2, "fullManual");
        } else if (mode == "Mixed") {
            const poke1 =
                pokemon1[Math.floor(Math.random() * pokemon1.length)].id;
            const poke2 =
                pokemon2[Math.floor(Math.random() * pokemon2.length)].id;
            battle(poke1, poke2, "Mixed");
        }
    };
    init();
});
