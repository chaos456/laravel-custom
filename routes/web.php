<?php

/** @var \Laravel\Lumen\Routing\Router $router */

$router->get('/example/custom_page', 'ExampleController@customPage');
$router->get('/example/custom_simple_page', 'ExampleController@customSimplePage');
$router->get('/example/exception', 'ExampleController@exception');
$router->get('/example/serial', ['middleware' => 'serial:order_id,5', 'uses' => 'ExampleController@serial']);
$router->get('/example/async_exec', 'ExampleController@asyncExec');
$router->get('/example/api_pre', 'ExampleController@apiPre');

