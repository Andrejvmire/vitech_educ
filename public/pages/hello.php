<?php

use Symfony\Component\HttpFoundation\Response;

if (isset($name)) {
    $response = new Response(sprintf('Hello %s', htmlspecialchars($name, ENT_QUOTES, 'UTF-8')));
};