async function getPokemon() {
    const response = await fetch("https://pokeapi.co/api/v2/pokedex/6/");
    const data = await response.json();
    const pokemons = data.pokemon_entries;
    pokemons.forEach((pokemon) => {
        const pokemonId = pokemon.pokemon_species.url.split("/")[6];
        pokemon.image = `https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/${pokemonId}.png`;
    });
    return pokemons;
}
const pokedex = getPokemon();
$(document).ready(function () {
    let table = $("#table").DataTable();
    pokedex.then((data) => {
        data.forEach((pokemon) => {
            table.row.add([
                pokemon.entry_number,
                `<img src="${pokemon.image}" />`,
                capitalizeFirstLetter(pokemon.pokemon_species.name),
            ]);
        });
        table.draw();
    });
});
function capitalizeFirstLetter(string) {
    return string.charAt(0).toUpperCase() + string.slice(1);
}
