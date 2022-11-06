<?php

namespace App\Http\Controllers;

use App\Models\EndPoint;
use Illuminate\Http\Request;
use App\Models\App;

class EndPointController extends Controller
{
    public function postRequest(App $app, Request $request)
    {

        //if app is not found
        if (!$app) {
            return response()->json([
                'message' => 'App not found'
            ], 404);
        }

        //check if app with mathing path is not found
        $endPoint = EndPoint::where('app_id', $app->id)->where('path', $request->path)->where('method', 'POST')->first();

        if (!$endPoint) {
            return response()->json([
                'message' => 'Endpoint not found'
            ], 404);
        }

        //get auth header
        $authHeader = $request->header('Authorization');

        //get the url to send the request to
        $url = $app->url;
        if ($endPoint->app_url_prefix) {
            $url .= '/' . $endPoint->app_url_prefix;
        }
        $url .= '/' . $request->path;

        //make POST request to endpoint
        $client = new \GuzzleHttp\Client();
        $response = $client->request('POST', $url, [
            'form_params' => $request->all(),
            'headers' => [
                'Authorization' => $authHeader
            ]
        ]);

        //return the response
        return json_decode($response->getBody());
    }
}
