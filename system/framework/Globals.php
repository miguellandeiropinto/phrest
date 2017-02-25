<?php

  use Symfony\Component\Yaml\Yaml;
  use Symfony\Component\Yaml\Exception\ParseException;

  $GLOBALS['configuration'] = null;
  global $configuration;

  try {
    $configuration = (object) Yaml::parse(file_get_contents('app.yml'));
  } catch (ParseException $e) {
      printf("Unable to parse the YAML string: %s", $e->getMessage());
      exit();
  }

  define('HEADER_ACCEPT', getallheaders()['Accept'] != 'application/json' && getallheaders()['Accept'] != 'application/xml' ? 'application/json' : getallheaders()['Accept']);
  define('API_KEY', isset($_GET['apikey']) ? $_GET['apikey'] : null);
  define('APP_NS', $configuration->app['namespace']);
  define('CTRLS_PATH', $configuration->app['controllers_path']);
  define('MODELS_PATH', $configuration->app['models_path']);
  define('CTRLS_NS', APP_NS . $configuration->app['controllers_namespace']);
  define('MODELS_NS', APP_NS . $configuration->app['models_namespace']);

  //header( 'Content-type: ' . HEADER_ACCEPT );

  ?>
