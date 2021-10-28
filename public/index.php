<?php

namespace App;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Controller\ArgumentResolver;
use Symfony\Component\HttpKernel\Controller\ControllerResolver;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;

require_once "../vendor/autoload.php";

ini_set("display_errors", 1);

$request = Request::createFromGlobals();
$routes = include './App.php';

$context = new RequestContext();
$context->fromRequest($request);

$matcher = new UrlMatcher($routes, $context);

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
    echo $exception->getMessage();
    $response = new Response("Ошибка сервера", 500);
}
$response->send();