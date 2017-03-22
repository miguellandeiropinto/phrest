<?php

namespace PhRestClient;

use Clue\Commander\Router;
use PhRestClient\Commands\Controller;
use PhRestClient\Commands\Model;
use PhRestClient\Commands\Config;
use PhRestClient\Commands\Install;

require __DIR__ . "/vendor/autoload.php";

class CLI
{

    protected $router;
    public $config;

    function __construct($config)
    {
        $this->config = $this->config;
        $this->router = new Router;
        $router = $this->router;

        $route_entities = $router->add('create <entity> <name> [<values>...]', function ($args) {

            if (!is_string($args['entity']) || !is_string($args['name'])):
                return false;
            endif;

            switch ($args['entity']) {
                case 'controller':
                    echo "[+] creating " . $args['name'] . " [controller] at " . APPCTRL_PATH . PHP_EOL;
                    Controller::create([
                            'namespace' => APP_CONFIG['app']['namespace'],
                            'class_name' => $args['name']]
                    );

                    break;
                case 'model':
                    echo "[+] creating " . $args['name'] . " [Model] at " . APPMODELS_PATH . PHP_EOL;
                    $data = [
                        'namespace' => APP_CONFIG['app']['namespace'],
                        'class_name' => $args['name']
                    ];
                    $data['table'] = isset($args['values'][0]) ? $args['values'][0] : '';
                    $data['fillable'] = isset($args['values'][1]) ? $args['values'][1] : '[]';
                    $data['xmlRoot'] = isset($args['values'][2]) ? $args['values'][2] : '';
                    $data['xmlNamespace'] = isset($args['values'][4]) ? $args['values'][4] : '';
                    $data['collectionXmlRoot'] = isset($args['values'][3]) ? $args['values'][3] : '';

                    Model::create($data);
                    break;
            }
        });
        $route_entities->help_desc = "Creates <controller> or <model> with a class name <name> and a group of [<values>...]. Check templates at system\cli\incliudes\\templates";

        $route_setEnv = $router->add('config setEnv <name> <value>', function ($args) {
            if (!$args['name'] && !$args['value']) return false;
            Config::setEnv($args['name'], $args['value']);
        });
        $route_setEnv->help_desc = "Sets or updates a envoirment variable in your .htaccess file.";

        $route_getEnv = $router->add('config getEnv <name>', function ($args) {
            if (!$args['name']) return false;
            Config::getEnv($args['name']);
        });

        $route_getEnv->help_desc = "Gets the value of a envoirment variable from .htaccess file.";

        $route_delEnv = $router->add('config deleteEnv <name>', function ($args) {
            if (!$args['name']) return false;
            Config::deleteEnv($args['name']);
        });
        $route_delEnv->help_desc = "Deletes an envoriment variable from .htaccess file.";

        $route_install = $router->add('install', function () {
            Install::start();
        });
        $route_install->help_desc = "Applies changes made in your app.yml file.";

        $route_init = $router->add('init', function () {
            Install::init();
        });
        $route_init->help_desc = "Initialize your project";

        $route_setc = $router->add('config set <key> <value>', function ($args) {
            if (!isset($args['value']) || !isset($args['key']))
                return false;
            Config::set($args['key'], $args['value']);
        });

        $route_setc->help_desc = "Sets a value in your app.yml file. Ex: db:host localhost | app:namespace MyApp";


        $route_getc = $router->add('config <key>', function ($args) {
            if (!isset($args['key']))
                return false;
            Config::get($args['key']);
        });
        $route_getc->help_desc = "Gets the value of a configuration on app.yml file. Ex: app:namespace";

        $route_h = $router->add('[--help | -h]', function () use ($router) {
            echo 'Usage:' . PHP_EOL;
            foreach ($router->getRoutes() as $route) {
                echo '  ' . $route . "\t" . $route->help_desc . PHP_EOL;
            }
        });

        $route_h->help_desc = "Shows usage of available commands.";

    }

    function run()
    {
        $this->router->execArgv();
    }

}


?>
