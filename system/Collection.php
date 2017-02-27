<?php

  namespace System;

  use Illuminate\Database\Eloquent\Collection as EloquentCollection;

  class Collection
    extends EloquentCollection
      implements XMLService, JSONService
  {

    public function __construct ($models, $namespace)
    {
      parent::__construct($models);
      $this->namespace = $namespace;
    }

    public function encodeXML ()
    {

    }

    public function decodeXML ( $xml = false )
    {

    }

    public function encodeJSON ()
    {
      $this->encodedJSON = json_encode((array) $this->items, JSON_PRETTY_PRINT);
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
