<?php

  namespace System;

  use System\Parser;

  class Request {

    protected $ID;
    protected $timestamp;
    protected $IP;
    public $headers;
    public $method;
    public $URIStr;
    public $query;
    public $URIArray;

    function __construct () {
      $this->ID = uniqid('request_');
      $this->timestamp = date("M d Y | H:i:s", time());
      $this->IP = $_SERVER['REMOTE_ADDR'];
      $this->headers = getallheaders();
      $this->stdin = file_get_contents("php://input", "r");
      $this->method = strtoupper( $_SERVER['REQUEST_METHOD'] );
      $this->URIStr = strtok(rtrim(ltrim($_SERVER['REQUEST_URI'],"/"), "/"), '?');
      $this->URIArray = explode('/', $this->URIStr);
      $this->queryStr = $_SERVER['QUERY_STRING'];
      parse_str( $this->queryStr, $this->query);
      $this->apiKey = isset($this->query['apikey']) ? $this->query['apikey'] : null;
      unset($this->query['apikey']);
    }

    function getEntity () {
      return strtolower($this->URIArray[0]);
    }

    function getMethod () {
      return $this->method;
    }

    function getID () {
      return $this->ID;
    }

    function getTimestamp () {
      return $this->timestamp;
    }

    function getIP () {
      return $this->IP;
    }

    public function getParams ( $param = array() ) {
      if ( is_array($param) ) {
        return $this->query;
      } elseif ( is_string($param) ) {
        return $this->query[$param] ? $this->query[$param] : null;
      }
    }

  }



?>
