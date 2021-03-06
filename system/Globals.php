<?php

use Symfony\Component\Yaml\Yaml;
use Symfony\Component\Yaml\Exception\ParseException;


$GLOBALS['configuration'] = null;

global $configuration;

try {
    $configuration = (object)Yaml::parse(file_get_contents('app.yml'));

} catch (ParseException $e) {
    printf("Unable to parse the YAML string: %s", $e->getMessage());
    exit();
}

$headers = getallheaders();

define('HEADER_ACCEPT', !isset($headers['Accept']) ? 'application/json' : $headers['Accept']);
define('HEADER_CONTENT_TYPE', !isset($headers['Content-Type']) ? 'application/json' : $headers['Content-Type']);
define('API_KEY', isset($_GET['apikey']) ? $_GET['apikey'] : null);
define('APP_NS', $configuration->app['namespace']);
define('CTRLS_PATH', $configuration->app['controllers_path']);
define('MODELS_PATH', $configuration->app['models_path']);
define('CTRLS_NS', APP_NS . $configuration->app['controllers_namespace']);
define('MODELS_NS', APP_NS . $configuration->app['models_namespace']);

define('DB_HOST', getenv('PR_DB_HOST'));
define('DB_NAME', getenv('PR_DB_NAME'));
define('DB_USER', getenv('PR_DB_USER'));
define('DB_PASSWORD', getenv('PR_DB_PASSWORD'));
define('DB_CHARSET', getenv('PR_DB_CHARSET'));
define('DB_COLLATION', getenv('PR_DB_COLLATION'));
define('DB_PORT', getenv('PR_DB_PORT'));
define('DB_DRIVER', getenv('PR_DB_DRIVER'));
define('APP_XML_NAMESPACE', getenv('PR_XML_NAMESPACE'));

$GLOBALS['ActionsManager'] = new \System\Actions\ActionsManager();
//header( 'Content-type: ' . HEADER_ACCEPT );

?>
