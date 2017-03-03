<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Artisaninweb\SoapWrapper\SoapWrapper;

class MainController extends Controller
{
     /**
     * @var SoapWrapper
     */
    protected $soapWrapper;

     /**
     * SoapController constructor.
     *
     * @param SoapWrapper $soapWrapper
     */
    public function __construct(SoapWrapper $soapWrapper)
    {
      $this->soapWrapper = $soapWrapper;
    }
    
     /**
     * Index
     * @param Request $request
     * @return string
     */
    public function index(Request $request)
    {
        $this->soapWrapper->add('Search', function ($service) {
            $service
              ->wsdl('http://roman.etm-system.de/etm-system/etm-webservice-0.3.1/server.php?WSDL')
              ->trace(true)
              ->options([
                'login'    => 'test',
                'password' => 'b4ApBWIaD9qK'
            ]);
        });
        
        $response = $this->soapWrapper->call('Search.ETM_DoAirFareRequest', []);
        
        return view('main.search_page', [
            'title' => 'E-tickets',
        ]);
    }
}