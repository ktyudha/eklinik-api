<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;

class SurabayaBusController extends Controller
{
    public function getMenuSb()
    {

        $client = new Client();
        $response = $client->request('POST', 'http://36.66.208.109/gbapi/gobis/api/menusb', [
            'headers' => [
                'Authorization' =>  'Basic YXJpZXN3aWRvZG9AZ21haWwuY29tOjEyMzQ1Ng==',
                "User-Agent" =>
                "Mozilla/5.0 (iPhone; CPU iPhone OS 16_6 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/16.6 Mobile/15E148 Safari/604.1",
            ],
            'form_params' => [
                'iduser' => 'dGFuUzA4Q3FCUnkvNXlZbmExVS9NZz09',
                'updatemenusb' => 1,
                'tglupdatemenusb' => Carbon::now()->startOfDay(),
            ]
        ]);

        $menusb = $response->getBody();
        return response()->json(json_decode($menusb));
    }

    public function getDetailRoute($routeId, $bearerToken)
    {
        $startOfDay = Carbon::now()->startOfDay();
        $formattedDate = $startOfDay->format('Y-m-d H:i:s');

        $client = new Client();
        $response = $client->request('GET', 'http://36.66.208.109/gbapi/gobis/initsb/' . $routeId . '/1/1/1/' . $formattedDate . '/' . $formattedDate . '/' . $formattedDate, [
            'headers' => [
                'Authorization' =>  'Bearer ' . $bearerToken,
                "User-Agent" =>
                "Mozilla/5.0 (iPhone; CPU iPhone OS 16_6 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/16.6 Mobile/15E148 Safari/604.1",
            ]
        ]);

        $detailRute         = $response->getBody();

        return response()->json(json_decode($detailRute));
    }
}
