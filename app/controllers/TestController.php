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
      $response->ok(Test::all()->encodeJSON()->encodedJSON)->send();
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

      if ( !$item )
          $response->notFound(json_encode(['message' => "no results"]))->send();

      $response->ok($item->encodeJSON()->encodedJSON)->send();

    }

      /**
       * @param Request $request
       * @param Response $response
       */
      public function create (Request $request, Response $response ) {

        if ( isset ($request->input->post->name) ) {
            $item = Test::create([
                'name' => $request->input->post->name
            ]);

            $json = $item->encodeJSON()->encodedJSON;
            $response->created($json)->send();
       } else {
            $response->badRequest(json_encode(['message' => 'Invalid data', 'code' => 400 ]))->send();
       }

    }

    public function put ( $request , $response ) {

        $query = $request->params['id'];

        $item = Test::where('id', $query)->orwhere('name', $query)->first();
        if ( !$item )
            $response->notFound(json_encode(['message' => 'no results']))->send();

    }

      public function delete ( $request , $response ) {

          $id = !property_exists($request->input->delete, 'id') ? null : $request->input->delete->id;

          if ( $id ) {
              $item = Test::where('id', $id)->orwhere('name', $id);
              if ( !$item )
                  $response->badRequest(json_encode(['message' => 'Missing data', 'code' => 400 ]))->send();

              $item->forceDelete();
              $response->ok(json_encode([]))->send();

          } else {
              $response->badRequest(json_encode(['message' => 'Missing data', 'code' => 400 ], JSON_PRETTY_PRINT))
                        ->send();
          }

          die();
      }

  }

?>
