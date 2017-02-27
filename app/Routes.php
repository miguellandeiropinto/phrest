<?php

  $router->get('/artists', 'TestController::index');

  $router->get('/artists/{id}', 'TestController::view')
          ->patterns(['id' => '/[a-zA-Z0-9]+/']);

  $router->post('/auth', 'AuthController::authenticate');

?>
