<?php

declare(strict_types=1);

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

require_once __DIR__ . '/Backend/config/config.php';
require_once __DIR__ . '/Backend/controllers/PokemonController.php';


$method = $_SERVER['REQUEST_METHOD']; // la solicitud del usuario (GET, POST, PUT, DELETE)
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH); // la ruta de la solicitud (api/pokemon/25)


$basePath = dirname($_SERVER['SCRIPT_NAME']);
if ($basePath !== '/') {
    $path = substr($path, strlen($basePath));
}
$pathParts = explode('/', trim($path, '/'));

$controller = new PokemonController();


// ROUTING - Decidir qué hacer según la URL
if ($method === 'GET' && $pathParts[0] === 'api' && $pathParts[1] === 'pokemon') {

    // Caso 1: /api/pokemon/25 (buscar un Pokémon)
    if (isset($pathParts[2]) && !isset($pathParts[3])) {
        $identifier = $pathParts[2];
        $pokemon = $controller->search($identifier);

        echo json_encode([
            'success' => true,
            'data' => [
                'id' => $pokemon->id,
                'name' => ucfirst($pokemon->name),
                'types' => $pokemon->types
            ]
        ]);
    }

    else {

        if (isset($_GET['type'])) {
            $pokemonList = $controller->getByType($_GET['type']);
            echo json_encode([
                'success' => true,
                'data' => $pokemonList
            ]);
        } elseif (isset($_GET['generation'])) {
            $pokemonList = $controller->getByGen((int)$_GET['generation']);
            echo json_encode([
                'success' => true,
                'data' => $pokemonList
            ]);
        }
    }
}
