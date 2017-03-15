<?php

    use System\ActionsManager;

    global $ActionsManager;




    // AuthorizeRoute action is called before the Route object is created
    // This is where you check if the user is logged in.

    function MyApp_onAuthorizeRoute ( $args ) {
        return false;
    }
    $ActionsManager->addAction('AuthorizeRoute', 'MyApp_onAuthorizeRoute');





    // onUnauthorizedRoute action is called when the AuthorizeRoute action call returns false (bool)
    // This is where you should send a error response or redirect user to authenticate.

    function MyApp_onUnauthorizedRoute ( $args ) {
        $args->response->unauthorized(json_encode(["message" => "Please authenticate!"]))->send();
    }
    $ActionsManager->addAction('onUnauthorizedRoute', 'MyApp_onUnauthorizedRoute');