<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Libs\DoAirFareRequest;
use App\Libs\GetAirFareResult;

class MainController extends Controller
{    
     /**
     * Show search form
     * @param Request $request
     * @return string
     */
    public function index(Request $request)
    {
        return view('main.search_page', [
            'title' => 'E-tickets'
        ]);
    }
    
    public function doAirFareRequest(Request $request)
    {
        $this->validate($request, [
            'departure_datetime'   => 'required|date',
            'original_location'    => 'required|string|min:3|max:3|regex:/(^[A-Za-z]+$)+/',
            'destination_location' => 'required|string|min:3|max:3|regex:/(^[A-Za-z]+$)+/',
            'passangers_quantity'  => 'required|integer|min:1'
        ]);
        
        $do_air_fare_request = new DoAirFareRequest();
        
        $do_air_fare_request->departure_datetime    = date("Y-m-d\TH:i:s", strtotime('2017-03-16 00:00:00'));
        $do_air_fare_request->original_location     = 'MOW';
        $do_air_fare_request->destination_location  = 'KGD';
        $do_air_fare_request->passangers_quantity   = 1;
        
        $response = $do_air_fare_request->call();
        
        if (!isset($response['response']->RequestId))
        {
            $error = isset($response['response']) ? $response['response'] : 'Unknown error';
            
            flash($error, 'danger');
            
            return redirect()->route('index');
        }
        
        return redirect()->route('search.flight', ['request_id' => $response['response']->RequestId]);
    }
    
    /**
     * Show waiting page for search
     * @param Request $request
     * @return string
     */
    public function searching(Request $request, $request_id)
    {
        return view('main.searching', [
            'title'      => 'E-tickets',
            'request_id' => $request_id
        ]);
    }
    
    /**
     * Index
     * @param Request $request
     * @return string
     */
    public function getAirFareResult(Request $request, $request_id)
    {
        $get_air_fare_request = new GetAirFareResult();
        
        $get_air_fare_request->request_id = $request_id;
        
        $i = 0;
        
        do {
            $response = $get_air_fare_request->call();

            if ($i !== 0)
            {
               sleep(1); 
            }

            $i++;
        } while ((isset($response['code'])) && ($response['code'] == 201));
        
        if (isset($response['error']) && ($response['error'] == true))
        {
            $error = isset($response['response']) ? $response['response'] : 'Unknown error';
            
            flash($error, 'danger');
            
            return response()->json([
                'status'   => 'error'
            ]);
        }
        
        flash('aeswfwef', 'success');
        
        return response()->json([
            'status'   => 'success',
            'response' => $response['response']
        ]);
    }
    
    /**
     * Show results of search
     * @param Request $request
     * @return string
     */
    public function result(Request $request)
    {
        return view('main.result', [
            'title' => 'E-tickets',
        ]);
    }
}