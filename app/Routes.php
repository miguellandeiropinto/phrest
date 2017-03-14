<?php

  $router->get('/artists', 'TestController::index');

  $router->post('/artists', 'TestController::create');

  $router->get('/artists/{id}', 'TestController::view')
          ->patterns(['id' => '/[a-zA-Z0-9]+/']);

  $router->put('/artists/{id}', 'TestController::put')
         ->patterns(['id' => '/[a-zA-Z0-9]+/']);

  $router->delete('/artists/{id}', 'TestController::delete')
    ->patterns(['id' => '/[a-zA-Z0-9]+/']);


