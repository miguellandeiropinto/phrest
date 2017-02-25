<?php

  namespace System;

  class Response
  {
    private $headers;
    function __construct ()
    {
      # code...
      $this->headers = [];
    }

    function setHeaders ( $headers = array() ) {
      $this->headers = array_merge($headers, $this->headers);
    }

    function _setHeaders () {
      foreach ( $this->headers as $key => $value )
      {
        header($key . ':' . $value);
      }
    }

    function setData ( $data, $root = null ) {
        if ( !$root && HEADER_ACCEPT == 'application/xml') $GLOBALS['error']->throwError(123, 'Error parsing XML!', 'application/json');
        $this->data = $data;
        $this->root = $root;
    }


  }

?>
