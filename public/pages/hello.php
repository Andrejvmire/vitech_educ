<?php

use Symfony\Component\HttpFoundation\Response;

$response = new Response(sprintf('Hello %s', htmlspecialchars($name, ENT_QUOTES, 'UTF-8')));