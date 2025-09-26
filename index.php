<?php
declare(strict_types=1);

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

require_once __DIR__ . '/Backend/config/config.php';
require_once __DIR__ . '/Backend/controllers/PokemonController.php';

$method = $_SERVER['REQUEST_METHOD']; //super global con la peticion (GET,POST)\
$user_url = $_SERVER['REQUEST_URI']; //url del usuario completo (http://localhost:8000/api/pokemon?details=25)
$path = parse_url($user_url, PHP_URL_PATH); //url del usuario sin parametros (api/pokemon)

$basePath = dirname($_SERVER['SCRIPT_NAME']);   //ruta base del script (api)
if ($basePath !== '/') {
    $path = substr($path, strlen($basePath));
}
$pathParts = explode('/', trim($path, '/')); 


if ($method !== 'GET' || $pathParts[0] !== 'api' || $pathParts[1] !== 'pokemon') { //validacion de la peticion
    http_response_code(404);
    echo json_encode(['success' => false, 'message' => 'Not found']);
    exit;
}

$controller = new PokemonController();
$result = null;


if (isset($pathParts[2]) && !isset($pathParts[3])) { 
    $result = $controller->search($pathParts[2]); // /api/pokemon/25
} elseif (isset($_GET['type'])) {
    $result = $controller->getByType($_GET['type']); // /api/pokemon?type=water
} elseif (isset($_GET['generation'])) {
    $result = $controller->getByGen((int)$_GET['generation']); // /api/pokemon?generation=2
} elseif (isset($_GET['ability'])) {
    $result = $controller->getByAbility($_GET['ability']); // /api/pokemon?ability=water-absorb
} elseif (isset($_GET['details'])) {
    $result = $controller->getDetails($_GET['details']); // /api/pokemon?details=25
}


if ($result === null) {
    http_response_code(404);
    echo json_encode(['success' => false, 'message' => 'Not found']);
} else {
    echo json_encode(['success' => true, 'data' => $result]);
}
?>