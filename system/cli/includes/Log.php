<?php
/**
 * Created by PhpStorm.
 * User: Utlizador
 * Date: 13/03/2017
 * Time: 01:17
 */

namespace PhRestClient\Includes;


define('INFO_MSG', '[+]');
define('ERROR_MSG', '[x]');
define('WARN_MSG', '[!]');

class Log
{
    function println ( $message, $type = INFO_MSG ) {
        echo $type . ' ' .  $message ."\n";
    }

    function printlnd ( $message, $type = INFO_MSG ) {
        Log::println( $message, $type );
        die();
        exit();
    }
}