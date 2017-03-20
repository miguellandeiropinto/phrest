<?php
/**
 * Created by PhpStorm.
 * User: Utlizador
 * Date: 14/03/2017
 * Time: 22:50
 */

namespace System\Actions;


class ActionsManager
{
    protected $actions = [];

    function addAction ( $action, $fn ) {
        $this->actions[ $action ] = [
            'fn' => $fn
        ];
    }

    function doAction ( $action = '', $args = []) {
        $args = (object) $args;
        if (array_key_exists($action, $this->actions)) {
            return call_user_func( $this->actions[$action]['fn'], $args );
        }
    }

}