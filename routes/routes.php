<?php

/** @var Bramus\Router\Router $router */

// Define routes here
$router->get('/test', App\Controllers\IndexController::class . '@test');
$router->get('/', App\Controllers\IndexController::class . '@test');
$router->get('/readfacility', App\Controllers\FacilityController::class . '@readFacility');
$router->get('/readfacilities', App\Controllers\FacilityController::class . '@readFacilities');
$router->post('/createfacility', App\Controllers\FacilityController::class . '@createFacility');