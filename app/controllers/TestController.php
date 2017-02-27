<?php

  namespace MyApp\Controllers;

  use System\Controller;
  use System\Request;
  use System\Response;
  use System\View;

  use MyApp\Models\Test;

  class TestController extends Controller
  {

    public function index ( Request $request, Response $response )
    {
      $json = Test::all()->encodeJSON()->encodedJSON;
      $response->setData( $json );
      $response->send();
    }

    public function view ( Request $request, Response $response )
    {
      # code..
      # var_dump($request->params);
      $query = $request->params['id'];
      $json = Test::where('id', $query)->orwhere('name', $query)->get()->encodeJSON()->encodedJSON;
      $response->setData( $json );
      $response->send();
    }

  }

?>
