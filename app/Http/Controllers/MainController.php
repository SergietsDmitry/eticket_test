<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Libs\DoAirFareRequest;
use App\Libs\GetAirFareResult;
use Session;
use Cities;

class MainController extends Controller
{    
     /**
     * Show search form
     * @param Request $request
     * @return string
     */
    public function index(Request $request)
    {
        if (empty($data = Session::get('session_search_data'))) {
            $data = new \stdClass;
            $data->departure_datetime   = '';
            $data->original_location    = '';
            $data->destination_location = '';
            $data->passangers_quantity  = '';
        }
        
        return view('main.search_page', [
            'title' => 'E-tickets',
            'data'  => $data
        ]);
    }
    
    public function doAirFareRequest(Request $request)
    {
        $this->validate($request, [
            'departure_datetime'   => 'required|date',
            'original_location'    => 'required|string|min:3|max:3|regex:/(^[A-Za-z]+$)+/',
            'destination_location' => 'required|string|min:3|max:3|regex:/(^[A-Za-z]+$)+/',
            'passangers_quantity'  => 'required|integer|min:1|regex:/(^[0-9]+$)+/'
        ]);
        
        $data = session('session_search_data') ?: new \stdClass;
        
        $data->departure_datetime      = $request->input('departure_datetime');
        $data->original_location       = $request->input('original_location');
        $data->destination_location    = $request->input('destination_location');
        $data->passangers_quantity     = $request->input('passangers_quantity');
        
        session(['session_search_data' => $data]);
        
        $do_air_fare_request = new DoAirFareRequest();
        
        $do_air_fare_request->departure_datetime    = $data->departure_datetime;
        $do_air_fare_request->original_location     = $data->original_location;
        $do_air_fare_request->destination_location  = $data->destination_location;
        $do_air_fare_request->passangers_quantity   = $data->passangers_quantity;
        
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
        
        return response()->json([
            'status'   => 'success',
            'response' => view('main.search_result', [
                'data'  => $response['response']
            ])->render()
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