$(document).ready(function () {
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
    $(".teamCheck").change(function () {
        //count how many are checked
        let count = 0;
        $(".teamCheck").each(function () {
            if (this.checked) {
                count++;
            }
        });
        if (count > 3) {
            this.checked = false;
        }
        let entityId = parseInt(this.nextElementSibling.innerText);
        fetch(`/pokemonTeam/` + entityId, {
            method: "POST",
            headers: {
                "X-CSRF-Token": $('meta[name="_token"]').attr("content"),
            },
        }).then((response) => {});
    });
});
