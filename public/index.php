<?php

/*
 * For incoming HTTP connections.
 * Handles  
 */

require "../vendor/autoload.php";

$request = new \Symfony\Component\HttpFoundation\Request($_GET, $_POST, [], $_COOKIE, $_FILES, $_SERVER);
$application = new \App\Application($request);

var_dump($request);