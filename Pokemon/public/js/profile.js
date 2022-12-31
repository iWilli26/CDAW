$(document).ready(function () {
    //relache le pokemon
    $(".release").click(function () {
        let pokemonId = parseInt(this.nextElementSibling.innerText);
        fetch(`/releasePokemon`, {
            method: "POST",
            headers: {
                "X-CSRF-Token": $('meta[name="_token"]').attr("content"),
            },
            body: JSON.stringify({
                pokemonId: pokemonId,
                userId: userId,
            }),
        }).then((response) => {
            window.location.href = "/profile";
        });
    });

    //ajoute le pokemon a l'equipe ou le retire
    $(".teamCheck").change(function () {
        let entityId = parseInt(this.nextElementSibling.innerText);
        fetch(`/pokemonTeam/` + entityId, {
            method: "POST",
            headers: {
                "X-CSRF-Token": $('meta[name="_token"]').attr("content"),
            },
        }).then((response) => {
            response.json().then((data) => {
                if (data === "level too low") {
                    alert("Pokemon level is too low to be on your team");
                    this.checked = false;
                } else if (data === "team full") {
                    alert("Your team is full");
                    this.checked = false;
                } else if (data === "energy not mastered") {
                    alert("Pokemon energy is not mastered");
                    this.checked = false;
                } else {
                    return;
                }
            });
        });
    });
});
