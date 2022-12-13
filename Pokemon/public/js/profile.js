$(document).ready(function () {
    $(".release").click(function () {
        let pokemonId = parseInt(this.nextElementSibling.innerText);
        console.log(pokemonId, userId);
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
});
