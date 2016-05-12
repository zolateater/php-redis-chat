<?php

/*
 * Примитивное приложение
 */


require "../vendor/autoload.php";

$request = \Symfony\Component\HttpFoundation\Request::createFromGlobals();

$application = new \App\Application();
$application->bootstrap();
$application->setRequest($request);

header("Set-Cookie: key=someOtherValue");

$response = $application->getResponse();
//$response->send();


