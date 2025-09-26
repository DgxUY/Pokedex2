const pokemonInput = document.getElementById("pokemon");
const searchButton = document.getElementById("search");
const resultDiv = document.getElementById("result");
const generationInput = document.getElementById("generation");
const searchButton2 = document.getElementById("search2");
const typeInput = document.getElementById("type");
const searchButton4 = document.getElementById("search4");
let allPokemonHTML = document.getElementById("result");


resultDiv.style.width = "100%";
resultDiv.style.height = "100%";
resultDiv.style.display = "flex";
resultDiv.style.flexWrap = "wrap";
resultDiv.style.justifyContent = "center";
resultDiv.style.alignItems = "center";
resultDiv.style.gap = "20px";

// ----------------------------------------------------------------------------------------------------------------------------------------
async function fetchPokemon(identifier) {
  try {
      const response = await fetch(`/api/pokemon/${identifier}`);
      const data = await response.json();
      
      renderPokemon(data.data); //data.data porque el json de la api tiene un objeto data que contiene el pokemon (success y data)
  } catch (error) {
      console.error(error);
  }
}
// ----------------------------------------------------------------------------------------------------------------------------------------
async function renderPokemon(pokemon) {
  allPokemonHTML.innerHTML += `
      <div class="pokemon-card">
          <p>${pokemon.name}</p>
          <p>${pokemon.types.map((type) => type.type.name).join(", ")}</p>
          <img src="${pokemon.sprites.front_default}">
      </div>
  `;
}
// ----------------------------------------------------------------------------------------------------------------------------------------
searchButton.addEventListener("click", () => {
  allPokemonHTML.innerHTML = '';
  if (pokemonInput.value === '') {
    console.error("Please enter a pokemon name");
    return;
  }
  fetchPokemon(pokemonInput.value);
});
// ----------------------------------------------------------------------------------------------------------------------------------------
searchButton2.addEventListener("click", async () => {
  
  
  const response = await fetch(`/api/pokemon?generation=${generationInput.value}`);
  const data = await response.json();
  
  if (data.success === false || data === null || data === undefined) {
      console.error("Generation not found");
      return;
  }
  
 data.data.forEach(pokemonName => fetchPokemon(pokemonName));
});

// ----------------------------------------------------------------------------------------------------------------------------------------
searchButton4.addEventListener("click", async () => {
  
  
  const response = await fetch(`/api/pokemon?type=${typeInput.value}`);
  const data = await response.json();
  
  if (data.success === false || data === null || data === undefined) {
      console.error("Type not found");
      return;
  }
 
 data.data.forEach(pokemonName => fetchPokemon(pokemonName));
});



