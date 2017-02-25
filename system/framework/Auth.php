<?php

  namespace System;

  class Auth {

    private $apikey;

    public function __construct () {
      $this->apiKey = API_KEY;
    }

    public function AuthOrExit () {

      if ( !API_KEY ) {
        return false;
      } else {
        return true;
      }

    }

  }

?>
