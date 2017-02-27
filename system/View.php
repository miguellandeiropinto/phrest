<?php

  namespace System;

  use System\Response;

  class View
  {
    public function render ( Response $response )
    {
      $response->_setHeaders();
      $data = $response->data;
      echo $data;
      return true;

    }
  }


?>
