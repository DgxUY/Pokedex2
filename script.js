const pokemonInput = document.getElementById("pokemon");
const searchButton = document.getElementById("search");
const resultDiv = document.getElementById("result");
const generationInput = document.getElementById("generation");
const searchButton2 = document.getElementById("search2");
const resultDiv2 = document.getElementById("result2");
const abilityInput = document.getElementById("ability");
const searchButton3 = document.getElementById("search3");
const resultDiv3 = document.getElementById("result3");
const loadMoreButton = document.getElementById("load-more");



searchButton.addEventListener("click", () => {
  const pokemonName = pokemonInput.value;
  fetch(`/api/pokemon/${pokemonName}`)
    .then((response) => response.json())
    .then((result) => {
      resultDiv.innerHTML = `
         <p>${result.data.name}</p>
         <p>${result.data.types.map((type) => type.type.name).join(", ")}</p>
         <img src="${result.data.sprites.front_default}"></img>
         <button id="See details">See details</button>
         `;
    })
    .catch((error) => {
      console.error("No se encontro el pokemon");
    });
});

searchButton2.addEventListener("click", () => {
  const generation = generationInput.value;
  fetch(`/api/pokemon?generation=${generation}`)
    .then((response) => response.json())
    .then((result) => {
      resultDiv2.innerHTML = `<p>${result.data.join(", ")}</p>`;
    })
    .catch((error) => {
      console.error("No se encontro la generacion");
    });
});

searchButton3.addEventListener("click", () => {
  const ability = abilityInput.value;
  fetch(`/api/pokemon?ability=${ability}`)
    .then((response) => response.json())
    .then((result) => {
      resultDiv3.innerHTML = `<p>${result.data.join(", ")}</p>`;
    })
    .catch((error) => {
      console.error("No se encontro la habilidad");
    });
});

resultDiv.addEventListener("click", () => {
    
})


let pokemonCount = 0;
let allPokemonHTML = '';

async function preloadPokemon() {
  await loadPokemon();
}

async function loadPokemon() {
  const startIndex = pokemonCount + 1;
  const endIndex = pokemonCount + 3;

  for (let i = startIndex; i <= endIndex; i++) {
    await fetch(`/api/pokemon/${i}`)
      .then((response) => response.json())
      .then((result) => {
        allPokemonHTML += `
                    <div class="pokemon-card">
                        <p>${result.data.name}</p>
                        <p>${result.data.types.map((type) => type.type.name).join(", ")}</p>
                        <img src="${result.data.sprites.front_default}">
                    </div>
                `;
      });
  }
  pokemonCount = endIndex;
  resultDiv.innerHTML = allPokemonHTML;
}

loadMoreButton.addEventListener("click", loadPokemon);
preloadPokemon();


