<?php

  $router->get('/artists', 'TestController::index');

  $router->get('/artists/{id}', 'TestController::view')
    ->patterns(['id' => '/[a-zA-Z0-9]+/']);

  $router->post('/artists', 'TestController::create');

  $router->put('/artists/{id}', 'TestController::put')
         ->patterns(['id' => '/[a-zA-Z0-9]+/']);

  $router->delete('/artists', 'TestController::delete');


