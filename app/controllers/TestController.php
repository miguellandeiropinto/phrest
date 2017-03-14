<?php

  namespace MyApp\Controllers;

  use System\Controller;
  use System\Request;
  use System\Response;
  use System\View;

  use MyApp\Models\Test;

  class TestController extends Controller
  {

      /**
       * @param Request $request
       * @param Response $response
       */
      public function index (Request $request, Response $response )
    {
      $json = Test::all()->encodeJSON()->encodedJSON;
      $response->setData( $json );
      $response->setCode(200);
      $response->send();
    }

      /**
       * @param Request $request
       * @param Response $response
       */
      public function view (Request $request, Response $response )
    {
      # code..
      $query = $request->params['id'];
      $item = Test::where('id', $query)->orwhere('name', $query)->first();

      if ( !$item ) {
        $response->setCode(200);
        $response->setData(json_encode([]));
        $response->send();
        die();
      }

      $json = $item->encodeJSON()->encodedJSON;
      $response->setData($json);
      $response->setCode(200);
      $response->send();
    }

      /**
       * @param Request $request
       * @param Response $response
       */
      public function create (Request $request, Response $response ) {

      if ( isset ($request->input->post['name']) ) {

        $item = Test::create([
            'name' => $request->input->post['name']
        ]);

        $json = $item->encodeJSON()->encodedJSON;
        $response->setData( $json );
        $response->setCode( 201 );
        $response->send();

      } else {

        $response->setData(json_encode(['message' => 'Invalid data', 'code' => 400 ]));
        $response->setCode( 400, 'Missing data');
        $response->send();

      }

    }

    public function put ( $request , $response ) {
        $query = $request->params['id'];
        $item = Test::where('id', $query)->orwhere('name', $query)->first();
        if ( !$item ) {
            $response->setData(json_encode(['error' => true ]));
            $response->setCode(200);
            $response->send();
            die();
        }
        $data = $request->input->put;
        die();
    }

      public function delete ( $request , $response ) {
          $query = $request->params['id'];
          $item = Test::where('id', $query)->orwhere('name', $query)->first();
          if ( !$item ) {
              $response->setData(json_encode(['error' => true ]));
              $response->setCode(200);
              $response->send();
              die();
          }
          $data = $request->input->delete;
          die();
      }

  }

?>
