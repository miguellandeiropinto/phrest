<?php

  namespace System;

  class Response
  {
    private $headers;
    function __construct ()
    {
      # code...
      $this->headers = [];
      $this->setHeaders([
        'Content-Type' => HEADER_ACCEPT,
      ]);
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

    function setData ( $data ) {
        $this->data = $data;
    }

    function send ()
    {
      View::render( $this );
    }

  }

?>
