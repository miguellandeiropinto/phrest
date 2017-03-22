<?php

namespace System\Http;

class Request
{

    protected $ID;
    protected $timestamp;
    protected $IP;
    public $headers;
    public $method;
    public $URIStr;
    public $params;
    public $query;
    public $URIArray;

    function __construct()
    {
        $this->ID = uniqid('request_');
        $this->timestamp = date("M d Y | H:i:s", time());
        $this->IP = $_SERVER['REMOTE_ADDR'];
        $this->headers = getallheaders();
        $this->method = strtoupper($_SERVER['REQUEST_METHOD']);
        $this->URIStr = strtok(rtrim(ltrim($_SERVER['REQUEST_URI'], "/"), "/"), '?');
        $this->URIArray = explode('/', $this->URIStr);
        $this->queryStr = $_SERVER['QUERY_STRING'];
        $this->params = [];
        parse_str($this->queryStr, $this->query);
        $this->apiKey = isset($this->query['apikey']) ? $this->query['apikey'] : null;
        unset($this->query['apikey']);
        $this->setInput();
    }

    function setInput()
    {

        $this->input = new \stdClass();;
        switch (HEADER_CONTENT_TYPE) {
            case "application/json":
                $this->input->put = json_decode(file_get_contents('php://input'));
                $this->input->post = json_decode(file_get_contents("php://input"));
                $this->input->get = json_decode(file_get_contents("php://input"));
                $this->input->delete = json_decode(file_get_contents('php://input'));
                $this->input->options = json_decode(file_get_contents('php://input'));
                $this->input->head = json_decode(file_get_contents('php://input'));
                $this->input->patch = json_decode(file_get_contents('php://input'));
                break;
            case "application/xml":

                break;
            case "application/x-www-form-urlencoded":
                $this->input->get = (object)$_GET;
                $this->input->post = (object)$_POST;
                parse_str(file_get_contents("php://input"), $this->input->put);
                $this->input->put = (object)$this->input->put;
                parse_str(file_get_contents("php://input"), $this->input->delete);
                $this->input->delete = (object)$this->input->delete;
                break;
            default:
                $this->input->get = (object)$_GET;
                $this->input->post = (object)$_POST;
                parse_str(file_get_contents("php://input", "r"), $this->input->options);
                parse_str(file_get_contents("php://input"), $this->input->head);
                parse_str(file_get_contents("php://input"), $this->input->patch);
                parse_str(file_get_contents("php://input", "r"), $this->input->put);
                parse_str(file_get_contents("php://input"), $this->input->delete);
                break;
        }
    }

    function getURL()
    {
        return '/' . $this->URIStr;
    }

    function getURIArray()
    {
        return $this->URIArray;
    }

    function getMethod()
    {
        return $this->method;
    }

    function getID()
    {
        return $this->ID;
    }

    function getTimestamp()
    {
        return $this->timestamp;
    }

    function getIP()
    {
        return $this->IP;
    }

    function getHeaders($param = [])
    {
        if (is_array($param)) {
            return $this->headers;
        } elseif (is_string($param)) {
            return $this->headers[$param] ? $this->headers[$param] : null;
        }
    }

    public function getParams($param = array())
    {
        if (is_array($param)) {
            return $this->query;
        } elseif (is_string($param)) {
            return $this->query[$param] ? $this->query[$param] : null;
        }
    }

}


?>
