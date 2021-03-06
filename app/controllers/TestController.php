<?php

namespace MyApp\Controllers;

use System\Http\Controller;
use System\Http\Request;
use System\Http\Response;

use MyApp\Models\Test;

class TestController extends Controller
{

    /**
     * @param Request $request
     * @param Response $response
     */
    public function index(Request $request, Response $response)
    {
        $response->setHeaders(["Content-Type" => "application/xml"])
            ->ok(Test::all()->encodeXML(null, ['created_at', 'updated_at'])->encodedXML)
            ->send();
    }

    /**
     * @param Request $request
     * @param Response $response
     */
    public function view(Request $request, Response $response)
    {
        # code..
        $query = $request->params['id'];
        $item = Test::where('id', $query)->orwhere('name', $query)->first();

        if (!$item)
            $response->notFound(json_encode(['message' => "no results"]))->send();

        $data = $item->encodeXML()->encodedXML;
        $response->setHeaders(["Content-Type" => "application/xml"])
            ->ok($data)
            ->send();

    }

    public function viewAlbuns(Request $request, Response $response)
    {
        $query = $request->params['id'];
        $item = Test::where('id', $query)->orwhere('name', $query)->first();
        $response->ok($item->albuns->encodeXML(['id'])->encodedXML)->send();
    }

    /**
     * @param Request $request
     * @param Response $response
     */
    public function create(Request $request, Response $response)
    {

        if (isset ($request->input->post->name)) {
            $item = Test::create([
                'name' => $request->input->post->name
            ]);

            $json = $item->encodeJSON()->encodedJSON;
            $response->created($json)->send();
        } else {
            $response->badRequest(json_encode(['message' => 'Invalid data', 'code' => 400]))->send();
        }

    }

    public function put($request, $response)
    {

        $query = $request->params['id'];

        $item = Test::where('id', $query)->orwhere('name', $query)->first();
        if (!$item)
            $response->notFound(json_encode(['message' => 'no results']))->send();

    }

    public function delete($request, $response)
    {

        $id = !property_exists($request->input->delete, 'id') ? null : $request->input->delete->id;

        if ($id) {
            $item = Test::where('id', $id)->orwhere('name', $id);
            if (!$item)
                $response->badRequest(json_encode(['message' => 'Missing data', 'code' => 400]))->send();

            $item->forceDelete();
            $response->ok(json_encode([]))->send();

        } else {
            $response->badRequest(json_encode(['message' => 'Missing data', 'code' => 400], JSON_PRETTY_PRINT))
                ->send();
        }

        die();
    }

}

?>
