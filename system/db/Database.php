<?php

  namespace System\Database;

  use Illuminate\Database\Capsule\Manager as Capsule;

  $db = new Capsule;
  $db->addConnection([
    'driver' => DB_DRIVER,
    'host' => DB_HOST,
    'port' => DB_PORT,
    'database' => DB_NAME,
    'user' => DB_USER,
    'password' => is_string(DB_PASSWORD) ? DB_PASSWORD : "",
    'charset' => DB_CHARSET,
    'collation' => DB_COLLATION
  ]);

  $db->setAsGlobal();
  $db->bootEloquent();

?>
