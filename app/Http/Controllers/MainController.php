<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Libs\Ping;
use App\Libs\DoAirFareRequest;
use App\Libs\GetAirFareResult;

class MainController extends Controller
{    
     /**
     * Index
     * @param Request $request
     * @return string
     */
    public function index(Request $request)
    {
        $ping = new DoAirFareRequest();
        
        $ping->call();

        dd(
            $ping->getSoapClient()->__getLastResponse(),
            $ping->getSoapClient()->__getLastResponseHeaders(),
            $ping->getSoapClient()->__getLastRequest(),
            $ping->getSoapClient()->__getLastRequestHeaders()
        );
        
        return view('main.search_page', [
            'title' => 'E-tickets',
        ]);
    }
}