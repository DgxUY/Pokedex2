const pokemonInput = document.getElementById("pokemon");
const searchButton = document.getElementById("search");
const resultDiv = document.getElementById("result");
const generationInput = document.getElementById("generation");
const searchButton2 = document.getElementById("search2");
const resultDiv2 = document.getElementById("result2");
const abilityInput = document.getElementById("ability");
const searchButton3 = document.getElementById("search3");
const resultDiv3 = document.getElementById("result3");

searchButton.addEventListener("click", () => {
  const pokemonName = pokemonInput.value;
  fetch(`/api/pokemon/${pokemonName}`)
    .then((response) => response.json())
    .then((result) => {
      resultDiv.innerHTML = `<p>${result.data.name}</p>
         <p>${result.data.types.map((type) => type.type.name).join(", ")}</p>
         <p>${result.data.moves
           .slice(0, 10)
           .map((move) => move.move.name)
           .join(", ")}</p>
         <p>${result.data.stats.map((stat) => stat.base_stat).join(", ")}</p>
         <img src="${result.data.sprites.front_default}"></img>
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
