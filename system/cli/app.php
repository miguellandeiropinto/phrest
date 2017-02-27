<?php

  namespace PhRestClient;

  use Clue\Commander\Router;
  use PhRestClient\Commands\Controller;
  use PhRestClient\Commands\Model;
  use PhRestClient\Commands\Config;

  require __DIR__ . "/vendor/autoload.php";

  class CLI {

    protected $router;
    public $config;

    function __construct ( $config )
    {
      $this->config = $this->config;
      $this->router = new Router;
      $router = $this->router;

      $r = $router->add('user list', function () {
        echo 'Here are all our users…' . PHP_EOL;
      });

      $routeCreate = $router->add('create <entity> <name> [<values>...]', function ( $args ) {

        if (!is_string($args['entity']) || !is_string($args['name'])):
          return false;
        endif;

        switch($args['entity'])
        {
          case 'controller':
            echo "[+] creating ".$args['name']." [controller] at " . APPCTRL_PATH . PHP_EOL;
            Controller::create([
              'namespace' => APP_CONFIG['app']['namespace'],
              'class_name' => $args['name']]
            );
            echo "[+] File ".$args['name'].".php created successfully at " . APPCTRL_PATH . PHP_EOL;
          break;
          case 'model':
            echo "[+] creating ".$args['name']." [Model] at " . APPMODELS_PATH . PHP_EOL;
            $data = [
              'namespace' => APP_CONFIG['app']['namespace'],
              'class_name' => $args['name']
            ];
            $data['table'] = isset($args['values'][0]) ? $args['values'][0] : '';
            $data['fillable'] = isset($args['values'][1]) ? $args['values'][1] : '[]';
            $data['xmlRoot'] = isset($args['values'][1]) ? $args['values'][2] : '';
            $data['xmlNamespace'] = isset($args['values'][1]) ? $args['values'][3] : '';

            Model::create($data);

            echo "[+] File ".$args['name']." created successfully at " . APPMODELS_PATH. PHP_EOL;
          break;
        }
      });

      $router->add('config <key> <value>', function ( $args ) {
        if ( !isset($args['value']) || !isset($args['key']))
          return false;
        Config::set($args['key'], $args['value']);
        echo "[+] Configuration changed successfully." . PHP_EOL;
      });

      $router->add('config <key>', function ( $args ) {
        if ( !isset($args['key']))
          return false;
        Config::get($args['key']);
      });

      $router->add('[--help | -h]', function () use ($router) {
        echo 'Usage:' . PHP_EOL;
        foreach ($router->getRoutes() as $route) {
          echo '  ' .$route . "      "  . PHP_EOL;
        }
      });

    }

    function run () {
      $this->router->execArgv();
    }

  }



?>
