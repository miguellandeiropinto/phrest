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
    public $params;
    public $query;
    public $URIArray;

    function __construct () {
      $this->ID = uniqid('request_');
      $this->timestamp = date("M d Y | H:i:s", time());
      $this->IP = $_SERVER['REMOTE_ADDR'];
      $this->headers = getallheaders();
      $this->method = strtoupper( $_SERVER['REQUEST_METHOD'] );
      $this->URIStr = strtok(rtrim(ltrim($_SERVER['REQUEST_URI'],"/"), "/"), '?');
      $this->URIArray = explode('/', $this->URIStr);
      $this->queryStr = $_SERVER['QUERY_STRING'];
      $this->params = [];
      parse_str( $this->queryStr, $this->query);
      $this->apiKey = isset($this->query['apikey']) ? $this->query['apikey'] : null;
      unset($this->query['apikey']);
      $this->setInput();
    }

    function setInput () {
        $this->input = new \stdClass();
        $this->input->get = $_GET;
        $this->input->post = isset($_POST) && count($_POST) > 0 ? $_POST : [];
        $this->input->put = null;
        $this->input->delete = null;
        parse_str(file_get_contents("php://input", "r"), $this->input->put);
        parse_str(file_get_contents("php://input"), $this->input->delete);
    }

    function getEntity () {
      return strtolower($this->URIArray[0]);
    }

    function getURL ()
    {
      return '/' . $this->URIStr;
    }

    function getURIArray ()
    {
      return $this->URIArray;
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

    function getHeaders () {
      return $this->headers;
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
