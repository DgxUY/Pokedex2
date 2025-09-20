<?php
declare(strict_types=1);
require_once dirname(__DIR__) . '/models/Pokemon.php';

class PokemonController
{
    public function search(int|string $identifier): ?Pokemon
    {
        return Pokemon::search($identifier);
    } 

    public function getPokemonByGen(int $gen): array
    {
        return Pokemon::getPokemonByGen($gen);
    }

    public function getPokemonByType(string $type): array
    {
        return Pokemon::getPokemonByType($type);
    }

    public function getEvolutionLine(int|string $identifier): ?array
    {
        $pokemon = Pokemon::search($identifier);
        return $pokemon?->getEvolutionLine(); 
    }


}