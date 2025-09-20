<?php
require_once dirname(__DIR__) . '/models/Pokemon.php';


function testController() {
    $controller = new PokemonController();
    
    echo "=== TESTS ===\n\n";
    
    // Test 1: Pokémon que existe
    echo "Test 1 - Pokémon existente:\n";
    $result = $controller->search(25);
    echo $result ? "✅ Pikachu encontrado\n" : "❌ Error\n";
    

    
    // Test 3: Evoluciones
    echo "\nTest 3 - Evoluciones:\n";
    $evolutions = $controller->getEvolutionLine(1);
    echo count($evolutions) === 3 ? "✅ Bulbasaur tiene 3 evoluciones\n" : "❌ Error en evoluciones\n";
    
    // Test 4: Búsqueda por tipo
    echo "\nTest 4 - Búsqueda por tipo:\n";
    $fireTypes = $controller->getPokemonByType("fire");
    echo count($fireTypes) > 0 ? "✅ Encontrados " . count($fireTypes) . " Pokémon tipo fuego\n" : "❌ Error\n";
    
    echo "\n=== FIN TESTS ===\n";
}

testController();
?>