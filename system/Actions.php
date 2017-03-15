<?php

    use System\ActionsManager;

    global $ActionsManager;

    function System_AuthorizeRoute ( $args ) {
        return true;
    }
    $ActionsManager->addAction('AuthorizeRoute', 'System_AuthorizeRoute');

    function System_onUnauthorizedRoute ( $args ) {
        var_dump('aaa');
        $args->response->unauthorized(json_encode(["message" => "Please authenticate!"]))->send();
    }
    $ActionsManager->addAction('onUnauthorizedRoute', 'System_OnUnauthorizedRoute');
