<?php

/** @var \Laravel\Lumen\Routing\Router $router */

$router->get('/', ['uses' => 'ExampleController@index']);
$router->get('/abc', ['uses' => 'ExampleController@index']);
