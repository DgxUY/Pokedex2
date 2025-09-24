<?php

declare(strict_types=1);

// Headers CORS completos
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

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

        if ($pokemon === null) {
            http_response_code(404);
            echo json_encode([
                'success' => false,
                'message' => 'Pokemon not found'
            ]);
            exit;
        }
        echo json_encode([
            'success' => true,
            'data' => $pokemon
        ]);
    } else {

        // Caso 2: /api/pokemon?type=water (buscar Pokémon por tipo)
        if (isset($_GET['type'])) {
            $pokemonList = $controller->getByType($_GET['type']);

            if ($pokemonList === null) {
                http_response_code(404);
                echo json_encode([
                    'success' => false,
                    'message' => 'Type not found'
                ]);
                exit;
            }
            echo json_encode([
                'success' => true,
                'data' => $pokemonList
            ]);

            // Caso 3: /api/pokemon?generation=2 (buscar Pokémon por generación) 
        } elseif (isset($_GET['generation'])) {
            $pokemonList = $controller->getByGen((int)$_GET['generation']);

            if ($pokemonList === null) {
                http_response_code(404);
                echo json_encode([
                    'success' => false,
                    'message' => 'Generation not found'
                ]);
                exit;
            }
            echo json_encode([
                'success' => true,
                'data' => $pokemonList
            ]);
            // Caso 4: /api/pokemon?ability=water (buscar Pokémon por habilidad)
        } elseif (isset($_GET['ability'])) {
            $pokemonList = $controller->getByAbility($_GET['ability']);

            if ($pokemonList === null) {
                http_response_code(404);
                echo json_encode([
                    'success' => false,
                    'message' => 'Ability not found'
                ]);
                exit;
            }
            echo json_encode([
                'success' => true,
                'data' => $pokemonList
            ]);
        } elseif (isset($_GET['details'])) {
            $pokemon = $controller->getDetails($_GET['details']);

            if ($pokemon === null) {
                http_response_code(404);
                echo json_encode([
                    'success' => false,
                    'message' => 'Pokemon not found'
                ]);
                exit;
            }
            echo json_encode([
                'success' => true,
                'data' => $pokemon
            ]);
        }
    }
}
