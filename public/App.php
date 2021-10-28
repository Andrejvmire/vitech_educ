<?php
namespace App;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

function is_leap_year($year = null): bool
{
    if ($year === null) {
        $year = date('Y');
    }
    var_dump($year);
    return 0 === $year % 400 || (0 === $year % 4 && 0 !== $year % 100);
}

$routeCollection = new RouteCollection();
$routeCollection->add("hello", new Route('/hello/{name}', [
    "name" => "World",
    "_controller" => "App\\HelloController::index",
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

return $routeCollection;