<?php

  namespace System;

  use System\Http\Request;

  class App {

    public $request;
    protected $router;
    public $route;

    public function __construct () {

      $this->request = new Request;
      $GLOBALS['Request'] = $this->request;

      $this->router = new Router;
      $this->route = $this->router->map($this->request);

    }

    public function run () {
      global $ActionsManager;
      if ( $this->route ) {
        if ( $this->route->needs('auth') ) {
            $authorized = $ActionsManager->doAction('AuthorizeRoute', (object)['request' => $this->request]);
            if (!$authorized) {
                $ActionsManager->doAction('onUnauthorizedRoute', (object) ["request" => $this->request, "response" => new Response()]);
            }
            $this->route->execute( $this->request );
        } else{
          $this->route->execute( $this->request );
        }
      }
    }

  }

?>
