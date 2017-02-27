<?php

  namespace System;
  use MyApp\Controllers;

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

      if ( $this->route )
      {
        $class = CTRLS_NS . '\\' . $this->route->class;
        $method = $this->route->method;
        $controller = new $class();
        $controller->$method($this->request, new Response());
      }

    }

  }

?>
