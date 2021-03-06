<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit0d0355011afb5ada8ca44a4263cc1941
{
    public static $files = array(
        '0e6d7bf4a5811bfa5cf40c5ccd6fae6a' => __DIR__ . '/..' . '/symfony/polyfill-mbstring/bootstrap.php',
        '667aeda72477189d0494fecd327c3641' => __DIR__ . '/..' . '/symfony/var-dumper/Resources/functions/dump.php',
    );

    public static $prefixLengthsPsr4 = array(
        'S' =>
            array(
                'Symfony\\Polyfill\\Mbstring\\' => 26,
                'Symfony\\Component\\Yaml\\' => 23,
                'Symfony\\Component\\VarDumper\\' => 28,
            ),
        'P' =>
            array(
                'PhRestClient\\Includes\\' => 22,
                'PhRestClient\\Commands\\' => 22,
            ),
        'C' =>
            array(
                'Clue\\Commander\\' => 15,
            ),
    );

    public static $prefixDirsPsr4 = array(
        'Symfony\\Polyfill\\Mbstring\\' =>
            array(
                0 => __DIR__ . '/..' . '/symfony/polyfill-mbstring',
            ),
        'Symfony\\Component\\Yaml\\' =>
            array(
                0 => __DIR__ . '/..' . '/symfony/yaml',
            ),
        'Symfony\\Component\\VarDumper\\' =>
            array(
                0 => __DIR__ . '/..' . '/symfony/var-dumper',
            ),
        'PhRestClient\\Includes\\' =>
            array(
                0 => __DIR__ . '/../..' . '/includes',
            ),
        'PhRestClient\\Commands\\' =>
            array(
                0 => __DIR__ . '/../..' . '/commands',
            ),
        'Clue\\Commander\\' =>
            array(
                0 => __DIR__ . '/..' . '/clue/commander/src',
            ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit0d0355011afb5ada8ca44a4263cc1941::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit0d0355011afb5ada8ca44a4263cc1941::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
