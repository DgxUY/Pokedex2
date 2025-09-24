<?php

declare(strict_types=1);

require_once dirname(__DIR__) . '/config/config.php';

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
        if ($response === false) {
            return null;
        }
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

    public static function getAbilities(): ?array
    {
        $url = POKEAPI_URL . "ability?limit=1000";
        $response = file_get_contents($url);
        if ($response === false) {
            return null;
        }

        $data = json_decode($response, true);

        $abilities = [];
        foreach ($data["results"] as $ability_data) {
            $abilities[] = $ability_data["name"];
        }
        return $abilities;
    }

    public static function getByAbility(string $ability): ?array
    {
        $url = POKEAPI_URL . "ability/" . $ability;
        $response = file_get_contents($url);
        if ($response === false) {
            return null;
        }
        $data = json_decode($response, true);

        $pokemon_names = [];
        foreach ($data["pokemon"] as $pokemon_data) {
            $pokemon_names[] = $pokemon_data["pokemon"]["name"];
        }
        return $pokemon_names;
    }

    public static function getByGen(int $gen): ?array
    {
        $url = POKEAPI_URL . "generation/" . $gen;
        $response = file_get_contents($url);
        if ($response === false) {
            return null;
        }
        $data = json_decode($response, true);

        $pokemon_names = [];
        foreach ($data["pokemon_species"] as $pokemon_data) {
            $pokemon_names[] = $pokemon_data["name"];
        }
        return $pokemon_names;
    }

    public static function getByType(string $type): ?array
    {
        $url = POKEAPI_URL . "type/" . strtolower($type);
        $response = file_get_contents($url);
        if ($response === false) {
            return null;
        }
        $data = json_decode($response, true);

        $pokemon_names = [];

        foreach ($data["pokemon"] as $pokemon_data) {
            $pokemon_names[] = $pokemon_data["pokemon"]["name"];
        }

        return $pokemon_names;
    }

    public function getDetails(): ?array
    {
        $url = POKEAPI_URL . "pokemon-species/" . $this->id;
        $response = file_get_contents($url);
        if ($response === false) {
            return null;
        }
        $data = json_decode($response, true);
        $lil_data = [];
        $lil_data[] = $data["color"]["name"];
        $lil_data[] = $data["flavor_text_entries"][0]["flavor_text"];
        return $lil_data;
    }


}


/*
    public function getEvolutionChain(): ?array
    {
        $url = $this->getDetails()["evolution_chain"]["url"];
        $response = file_get_contents($url);
        if ($response === false) {
            return null;
        }
        return json_decode($response,  true);
    }

    public function getEvolutionLine(): ?array
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

*/