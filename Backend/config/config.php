<?php

// constants

const POKEAPI_URL = "https://pokeapi.co/api/v2/";
const DEFAULT_LIMIT = 20;
const MAX_LIMIT = 300;

const DEBUG_MODE = true;

function debug($message) {
    if (DEBUG_MODE) {
        error_log("DEBUG: " . print_r($message, true));
    }
}

?>
