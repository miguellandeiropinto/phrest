<?php

require __DIR__ . '/../vendor/autoload.php';

$router = new Clue\Commander\Router();
$router->add('exit [<code:uint>]', function (array $args) {
    $code = isset($args['code']) ? $args['code'] : 0;

    if ($code > 255) {
        throw new \InvalidArgumentException('Invalid exit code given');
    }

    exit($code);
});
$router->add('sleep <seconds:uint>', function (array $args) {
    sleep($args['seconds']);
});
$router->add('echo <words>...', function (array $args) {
    echo join(' ', $args['words']) . PHP_EOL;
});
$router->add('[--help | -h]', function () use ($router) {
    echo 'Usage:' . PHP_EOL;
    foreach ($router->getRoutes() as $route) {
        echo '  ' . $route . PHP_EOL;
    }
});

try {
    $router->handleArgv();
} catch (Clue\Commander\NoRouteFoundException $e) {
    echo 'Usage error: ' . $e->getMessage() . PHP_EOL;
    echo 'Run without arguments if you need help with usage' . PHP_EOL;
} catch (Exception $e) {
    echo 'Program error: ' . $e->getMessage() . PHP_EOL;
}
