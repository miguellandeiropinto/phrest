<?php

use System\ActionsManager;

global $ActionsManager;

function System_AuthorizeRoute($args)
{
    return true;
}

$ActionsManager->addAction('AuthorizeRoute', 'System_AuthorizeRoute');

function System_onUnauthorizedRoute($args)
{
    $args->response->unauthorized(json_encode(["message" => "Please authenticate!"]))->send();
}

$ActionsManager->addAction('onUnauthorizedRoute', 'System_OnUnauthorizedRoute');

function System_onRouteNotFound($args)
{
    $args->response->notFound(json_encode(["message" => "Couldn't find a matching route."]))->send();
}

$ActionsManager->addAction('onRouteNotFound', 'System_onRouteNotFound');