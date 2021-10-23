<?php
require_once "../vendor/autoload.php";

ini_set("display_errors", 1);

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

$request = Request::createFromGlobals();
$response = new Response();

$name = $request->get("name", "World");

$maps = [
    "/hello" => "./pages/hello.php",
    "/bye" => "./pages/bye.php",
];

$path = $request->getPathInfo();
if (isset($maps[$path])) {
    require $maps[$path];
} else {
    $response->setStatusCode(404);
    $response->setContent("Страница не найдена");
}
$response->send();