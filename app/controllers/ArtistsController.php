<?php

  namespace MyApp\Controllers;

  use System\Controller;
  use System\Request;
  use System\Response;
  use MyApp\Models\Artist;

  class ArtistsController extends Controller
  {

    public function GET ( Request $request, Response $reponse )
    {
      #code...
      dd( (object) $request->headers );
    }

    public function POST ( Request $request, Response $reponse )
    {
      #code...
      dd( (object) $request->headers );
    }

    public function PUT ( Request $request, Response $reponse )
    {
      #code...
      dd("putting "  . mb_strlen($request->stdin,'8bit'));
    }

    public function DELETE ( Request $request, Response $reponse )
    {
      #code...
    }

  }

?>
