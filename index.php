<?php
  include(__DIR__ . '/vendor/autoload.php');

  use System\Auth;
  use System\App;

  global $configuration;
  if ( !$configuration ) exit();

  $app = new App();
  $app->run();
