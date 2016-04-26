<?php

/*
 * For incoming HTTP connections.  
 */

require "../vendor/autoload.php";

$request = new \Symfony\Component\HttpFoundation\Request($_GET, $_POST, [], $_COOKIE, $_FILES, $_SERVER);