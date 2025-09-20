<?php

declare(strict_types=1);

require_once dirname(__DIR__) . '/config/config.php';


// __DIR__ = directorio actual
// dirname(__DIR__) = directorio padre

class Pokemon
{

    public function __construct(
        public int $id,
        public string $name,
        public int $height,
        public int $weight,
        public array $types,
        public array $abilities,
        public array $moves,
        public array $stats,
        public array $sprites,
    ) {}

    public static function search(int | string $identifier): ?self
    {

        $url = POKEAPI_URL . "pokemon/" . $identifier;
        $response = file_get_contents($url);
        $data = json_decode($response, true);

        return new self(
            $data["id"],
            $data["name"],
            $data["height"],
            $data["weight"],
            $data["types"],
            $data["abilities"],
            $data["moves"],
            $data["stats"],
            $data["sprites"],
        );
    }

    public static function getPokemonByGen(int $gen): array
    {
        $url = POKEAPI_URL . "generation/" . $gen;
        $response = file_get_contents($url);
        $data = json_decode($response, true);

        $pokemon_names = [];
        foreach ($data["pokemon_species"] as $pokemon_data) {
            $pokemon_names[] = $pokemon_data["name"];
        }
        return $pokemon_names;
    }

    public static function getPokemonByType(string $type): array
    {
        $url = POKEAPI_URL . "type/" . strtolower($type);
        $response = file_get_contents($url);
        $data = json_decode($response, true);

        $pokemon_names = [];

        foreach ($data["pokemon"] as $pokemon_data) {
            $pokemon_names[] = $pokemon_data["pokemon"]["name"];
        }

        return $pokemon_names;
    }

    public function getDetails(): array
    {
        $url = POKEAPI_URL . "pokemon-species/" . $this->id;
        $response = file_get_contents($url);
        $data = json_decode($response, true);
        return $data;
    }

    public function getEvolutionChain(): array
    {
        $url = $this->getDetails()["evolution_chain"]["url"];
        $response = file_get_contents($url);
        return json_decode($response, true);
    }

    public function getEvolutionLine(): array
    {
        $evolution_chain = $this->getEvolutionChain();
        $evolution_line = [];
        $current_pokemon = $evolution_chain["chain"];

        while ($current_pokemon) {
            $evolution_line[] = $current_pokemon["species"]["name"];
            $current_pokemon = $current_pokemon["evolves_to"][0] ?? null;
        }
        return $evolution_line;
    }
}




// $pokemon = Pokemon::search("Bulbasaur");
// echo implode(" , ", $pokemon->getEvolutionLine());


// $pokemon = Pokemon::getPokemonByType("grass");
// echo implode(" , ", $pokemon);

// $pokemon = Pokemon::getPokemonByGen(1);
// echo implode(" , ", $pokemon);

$pokemon = Pokemon::search("Bulbasaur");
echo implode(" , ", array_map(function($stat) { return $stat["base_stat"]; }, $pokemon->stats));
echo "\n";
echo implode(" , ", array_map(function($move) { return $move["move"]["name"]; }, $pokemon->moves));
