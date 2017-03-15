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

    function created ( $json = "" ) {
        $this->setData($json);
        $this->setCode(201);
        return $this;
    }

    function ok ( $json = "" ) {
        $this->setData($json);
        $this->setCode(200);
        return $this;
    }

    function notFound ( $json = "" ) {
      $this->setData($json);
      $this->setCode(404);
      return $this;
    }

    function unauthorized ( $json = "" ) {
        $this->setData($json);
        $this->setCode(401);
        return $this;
    }

    function badRequest ( $json = "") {
        $this->setData($json);
        $this->setCode(400);
        return $this;
    }

    function send ()
    {
      View::render( $this );
      die();
    }

  }

?>
