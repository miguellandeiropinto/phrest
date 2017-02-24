<?php

require __DIR__ . '/app/config.php';
global $appconfig;
return [
  'paths' => [
    'migrations' => __DIR__ . '/system/db/migrations'
  ],
  'migration_base_class' => '\System\Database\Migration',
  'environments' => [
    'default_migration_table' => 'phinxlog',
    'default_database' => 'dev',
    'dev' => [
      'adapter' => 'mysql',
      'host' => $appconfig['DB']['HOST'],
      'name' => $appconfig['DB']['DBNAME'],
      'user' => $appconfig['DB']['USER'],
      'pass' => $appconfig['DB']['PWD'],
      'port' => 3306
    ]
  ]
];

?>
