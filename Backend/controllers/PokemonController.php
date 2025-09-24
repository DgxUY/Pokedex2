<?php
declare(strict_types=1);
require_once dirname(__DIR__) . '/models/Pokemon.php';

class PokemonController
{
    public function search(int|string $identifier): ?Pokemon
    {
        return Pokemon::search($identifier);
    } 

    public function getByGen(int $gen): ?array
    {
        return Pokemon::getByGen($gen);
    }

    public function getByType(string $type): ?array
    {
        return Pokemon::getByType($type);
    }

    public function getDetails(string|int  $identifier): ?array
    {
        return Pokemon::search($identifier)->getDetails($identifier);
    }

/*
     public function getEvolutionLine(int|string $identifier): ?array
    {
        $pokemon = Pokemon::search($identifier);
        return $pokemon?->getEvolutionLine(); 
    }

*/
    public function getByAbility(string $ability): ?array
    {
        return Pokemon::getByAbility($ability);
    }


} 