<?php

    use System\ActionsManager;

    global $ActionsManager;


    function MyApp_onAuthorizeRoute ( $args ) {
        return true;
    }
    $ActionsManager->addAction('AuthorizeRoute', 'MyApp_onAuthorizeRoute');




    /*function MyApp_onUnauthorizedRoute ( $args ) {
        $args->response->unauthorized(json_encode(["message" => "Please authenticate!"]))->send();
    }
    $ActionsManager->addAction('onUnauthorizedRoute', 'MyApp_onUnauthorizedRoute');
    */