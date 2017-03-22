<?php
/**
 * Created by PhpStorm.
 * User: Utlizador
 * Date: 12/03/2017
 * Time: 23:58
 */

namespace PhRestClient\Commands;

use PhRestClient\Commands\Config;
use Symfony\Component\Yaml\Yaml;
use Symfony\Component\Yaml\Exception\ParseException;
use PhRestClient\Includes\Log;


class Install
{
    function start($args = array())
    {
        $yml = [
            'db' => [
                'host' => 'localhost',
                'db' => 'phrest_db',
                'user' => 'toor',
                'password' => '',
                'port' => 3306,
                'charset' => 'utf8',
                'collation' => 'utf8_unicode_ci',
                'driver' => 'mysql'
            ],
            'app' => [
                'namespace' => 'MyApp',
                'controllers_namespace' => '\Controllers',
                'models_namespace' => '\Models',
                'controllers_path' => '/app/controllers/',
                'models_path' => '/app/models',
                'namespaceXML' => 'http://www.example.org/'
            ]
        ];

        $config = null;

        if (file_exists(__DIR__ . '/../../../app.yml')) {
            try {
                $config = Yaml::parse(file_get_contents(__DIR__ . '/../../../app.yml'));
            } catch (ParseException $e) {
                Log::printlnd("Unable to parse the YAML string: " . $e->getMessage());
            }

            $config = array_merge($yml, $config);

            Config::setEnv('DB_HOST', $config['db']['host']);
            Config::setEnv('DB_NAME', $config['db']['db']);
            Config::setEnv('DB_USER', $config['db']['user']);
            Config::setEnv('DB_PASSWORD', $config['db']['password']);
            Config::setEnv('DB_CHARSET', $config['db']['charset']);
            Config::setEnv('DB_COLLATION', $config['db']['collation']);
            Config::setEnv('DB_PORT', $config['db']['port']);
            Config::setEnv('DB_DRIVER', $config['db']['driver']);
            Config::setEnv('XML_NAMESPACE', $config['app']['namespaceXML']);


            Log::println('.htaccess file changed!');
            Log::printlnd("PhRest installed!");

        } else {
            Log::printlnd("Couldn't found app.yml file! Exiting!", ERROR_MSG);
        }

    }

    function init()
    {
        $yml = [
            'db' => [
                'host' => 'localhost',
                'db' => 'phrest_db',
                'user' => 'root',
                'password' => 'toor',
                'port' => 3306,
                'charset' => 'utf8',
                'collation' => 'utf8_unicode_ci',
                'driver' => 'mysql'
            ],
            'app' => [
                'namespace' => 'MyApp',
                'controllers_namespace' => '\Controllers',
                'models_namespace' => '\Models',
                'controllers_path' => '/app/controllers/',
                'models_path' => '/app/models',
                'namespaceXML' => 'http://www.example.org/'
            ]
        ];

        if (!file_exists(__DIR__ . '/../../../app.yml')) {
            try {
                file_put_contents(__DIR__ . '/../../../app.yml', Yaml::dump($yml));
            } catch (Exception $e) {
                echo $e->getMessage();
                die();
            }
            Log::println('app.yml file created successfully!');
            Log::println('This file shouldn\'t exist in production!');
        } else {
            Log::println('app.yml already exists!', WARN_MSG);
            Log::printlnd('Use -h | --help to see how to manage this file!');
        }
    }
}