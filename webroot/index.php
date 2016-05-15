<?php

/*
 * Примитивное приложение
 */

use App\Application;
use Symfony\Component\HttpFoundation\Request;

require "../vendor/autoload.php";

$request = Request::createFromGlobals();
$application = new Application('redis');
$response = $application->handleRequest($request);
$response->send();


