<?php

/** @var Bramus\Router\Router $router */

// Define routes here
$router->get('/test', App\Controllers\IndexController::class . '@test');
$router->get('/', App\Controllers\IndexController::class . '@test');
$router->get('/readfacility', App\Controllers\FacilityController::class . '@readFacility');
$router->get('/readfacilities', App\Controllers\FacilityController::class . '@readFacilities');
$router->post('/createfacility', App\Controllers\FacilityController::class . '@createFacility');
$router->post('/deletefacility', App\Controllers\FacilityController::class . '@deleteFacility');
$router->post('/updatefacilityname', App\Controllers\FacilityController::class . '@updateFacilityName');
$router->post('/updatefacilitycreationdate', App\Controllers\FacilityController::class . '@updateFacilityCreationDate');
$router->post('/addfacilitytag', App\Controllers\FacilityController::class . '@addFacilityTag');
$router->post('/deletefacilitytag', App\Controllers\FacilityController::class . '@deleteFacilityTag');
$router->post('/createfacilitytag', App\Controllers\FacilityController::class . '@createFacilityTag');
$router->post('/searchfacility', App\Controllers\FacilityController::class . '@searchFacility');