<?php

/*
 * lkz   
 */


require "../vendor/autoload.php";

$request = \Symfony\Component\HttpFoundation\Request::createFromGlobals();

$application = new \App\Application();
$application->bootstrap();
$application->setRequest($request);

$response = $application->getResponse();
$response->send();


