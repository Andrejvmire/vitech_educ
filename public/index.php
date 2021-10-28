<?php

namespace App;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

require_once "../vendor/autoload.php";

ini_set("display_errors", 1);

$request = Request::createFromGlobals();
$routeCollection = new RouteCollection();
$routeCollection->add("hello", new Route('/hello/{name}', ["name" => "World"]));
$routeCollection->add("bye", new Route("/bye"));
$context = new RequestContext();
$context->fromRequest($request);

$matcher = new UrlMatcher($routeCollection, $context);

try {
    extract($matcher->match($request->getPathInfo()), EXTR_SKIP);
    ob_start();
    include sprintf('./pages/%s.php', $_route);

    $response = new Response(ob_get_clean());
} catch (ResourceNotFoundException $exception) {
    $response = new Response("Страница не  найдена", 404);
} catch (\Exception $exception) {
    $response = new Response("Ошибка сервера", 500);
}
$response->send();