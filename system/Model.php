<?php

  namespace System;

  use Illuminate\Database\Eloquent\Model as Eloquent;

  interface XMLService {

    public function decodeXML( $xml );
    public function encodeXML();

  }

  interface JSONService {

    public function decodeJSON( $json );
    public function encodeJSON();

  }

  class Model
    extends Eloquent
      implements XMLService, JSONService
  {

    protected $namespace;

    public function encodeXML ()
    {
      $service = new \Sabre\Xml\Service();
      return $this;
    }

    public function decodeXML ( $xml = false )
    {
      $service = new \Sabre\Xml\Service();
      return $this;
    }

    public function newCollection(array $models = [])
    {
        return new Collection($models, $this->namespace);
    }

    public function encodeJSON ()
    {
      $this->encodedJSON = json_encode((array) $this->attributes, JSON_PRETTY_PRINT);
      return $this;
    }

    public function decodeJSON ( $json = false )
    {
      $json = !$json ? $this->encodeJSON()->encodedJSON : $json;
      $this->decodedJSON = json_decode($json);
      return $this;
    }

  }

?>
