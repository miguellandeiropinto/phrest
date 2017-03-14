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
      header( $this->code );
      foreach ( $this->headers as $key => $value )
      {
        header($key . ':' . $value);
      }
    }

    function setData ( $data ) {
        $this->data = $data;
    }

    function setCode ( $code = 200, $reason = "" ) {
        $this->code = "HTTP/1.1 " . $code . $reason;
    }

    function send ()
    {
      View::render( $this );
    }

  }

?>
