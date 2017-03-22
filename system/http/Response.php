<?php

namespace System\Http;

use System;

class Response
{
    private $headers;

    function __construct()
    {
        # code...
        $this->headers = [];
        $this->setCode(200);
        $this->setHeaders([
            'Content-Type' => HEADER_ACCEPT,
        ]);
    }

    function setHeaders($headers = array())
    {
        $this->headers = array_merge($headers, $this->headers);
        return $this;
    }

    function _setHeaders()
    {
        header($this->code);
        foreach ($this->headers as $key => $value) {
            header($key . ':' . $value);
        }
    }

    function setData($data)
    {
        $this->data = $data;
        return $this;
    }

    function setCode($code = 200, $reason = "")
    {
        $this->code = "HTTP/1.1 " . $code . $reason;
        return $this;
    }

    function created($str = "")
    {
        $this->setData($str);
        $this->setCode(201);
        return $this;
    }

    function ok($str = "")
    {
        $this->setData($str);
        $this->setCode(200);
        return $this;
    }

    function notFound($str = "")
    {
        $this->setData($str);
        $this->setCode(404);
        return $this;
    }

    function unauthorized($str = "")
    {
        $this->setData($str);
        $this->setCode(401);
        return $this;
    }

    function badRequest($str = "")
    {
        $this->setData($str);
        $this->setCode(400);
        return $this;
    }

    function send()
    {
        $r = $this;
        System\View::render($r);
        die();
        exit();
    }

}

?>
