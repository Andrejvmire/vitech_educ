<?php

namespace App;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Controller\ArgumentResolver;
use Symfony\Component\HttpKernel\Controller\ControllerResolver;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

require_once "../vendor/autoload.php";

ini_set("display_errors", 1);

function render_template(Request $request): Response
{
    extract($request->attributes->all(), EXTR_SKIP);
    ob_start();
    include sprintf('./pages/%s.php', $_route);
    return new Response(ob_get_clean());
}

function is_leap_year($year = null): bool
{
    if ($year === null) {
        $year = date('Y');
    }
    var_dump($year);
    return 0 === $year % 400 || (0 === $year % 4 && 0 !== $year % 100);
}

$request = Request::createFromGlobals();
$routeCollection = new RouteCollection();
$routeCollection->add("hello", new Route('/hello/{name}', [
    "name" => "World",
    "_controller" => function ($request) {
        return render_template($request);
    },
]));
$routeCollection->add("bye", new Route("/bye", [
    "_controller" => function ($request) {
        return render_template($request);
    },
]));

$routeCollection->add("leapYear", new Route("/leap_year/{year}", [
    "year" => null,
    "_controller" => "App\\LeapYearController::index",
]));

$context = new RequestContext();
$context->fromRequest($request);

$matcher = new UrlMatcher($routeCollection, $context);

$controllerResolver = new ControllerResolver();
$argumentResolver = new ArgumentResolver();

try {
    $request->attributes->add($matcher->match($request->getPathInfo()));
    $controller = $controllerResolver->getController($request);
    $arguments = $argumentResolver->getArguments($request, $controller);
    $response = call_user_func($controller, $arguments);
} catch (ResourceNotFoundException $exception) {
    $response = new Response("Страница не  найдена", 404);
} catch (\Exception $exception) {
    $response = new Response("Ошибка сервера", 500);
}
$response->send();