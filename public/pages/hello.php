<?php

use Symfony\Component\HttpFoundation\Response;

$name = $request->get("name", "World");

$response = new Response(sprintf('Hello %s', htmlspecialchars($name, ENT_QUOTES, 'UTF-8')));