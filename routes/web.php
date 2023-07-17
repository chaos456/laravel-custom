<?php

/** @var \Laravel\Lumen\Routing\Router $router */

$router->get('/custom_page', 'ExampleController@customPage');
$router->get('/custom_simple_page', 'ExampleController@customSimplePage');
$router->get('/exception', 'ExampleController@exception');
$router->get('/serial', ['middleware' => 'serial:order_id,5', 'uses' => 'ExampleController@serial']);
$router->get('/async_exec', 'ExampleController@asyncExec');
$router->get('/where_eq_date', 'ExampleController@whereEqDate');
$router->get('/log', 'ExampleController@log');
