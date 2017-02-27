<?php

  namespace System\Database;

  use Illuminate\Database\Capsule\Manager as Capsule;

  global $configuration;

  $dbconfig = (object) $configuration->db;

  $db = new Capsule;
  $db->addConnection([
    'driver' => $dbconfig->adapter,
    'host' => $dbconfig->host,
    'port' => $dbconfig->port,
    'database' => $dbconfig->name,
    'user' => $dbconfig->user,
    'password' => $dbconfig->password,
    'charset' => $dbconfig->charset,
    'collation' => $dbconfig->collation
  ]);

  $db->setAsGlobal();
  $db->bootEloquent();

?>
