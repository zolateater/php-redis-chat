<?php

/**
 * Файл предназначается исключительно для работы встроенного PHP-сервера, 
 * и предназначен только для разработки 
 */

$requestedFile = __DIR__ . $_SERVER["REQUEST_URI"];
if (file_exists($requestedFile)) {
    return;
}

include __DIR__ . "/index.php";
    