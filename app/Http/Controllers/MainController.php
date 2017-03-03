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
        $sxe = new \SimpleXMLElement('<packagedElement></packagedElement>');
        
        $security = $sxe->addChild('Security');
        $security->addChild('Username', 'test');
        $security->addChild('Password', 'b4ApBWIaD9qK');
        $security->addChild('HashKey', 'a1601fb45b');
        
        $original_destination = $sxe->addChild('OriginDestinationInformation');
        $original_destination->addChild('DepartureDateTime', date("Ymd"));
        $original_destination->addChild('OriginLocation', 'MOW');
        $original_destination->addChild('DestinationLocation', 'MUC');
        
        $original_destination = $sxe->addChild('OriginDestinationInformation');
        $original_destination->addChild('DepartureDateTime', date("Ymd"));
        $original_destination->addChild('OriginLocation', 'MUC');
        $original_destination->addChild('DestinationLocation', 'MOW');
        
        $traveler_info_summary = $sxe->addChild('TravelerInfoSummary');
        $passenger = $traveler_info_summary->addChild('Passenger');
        $passenger->addChild('Type', 'ADT');
        $passenger->addChild('Quantity', '2');
        
        $soapclient = new \SoapClient("http://roman.etm-system.de/etm-system/etm-webservice-0.3.1/server.php?WSDL", [
            "location"=>"http://schemas.xmlsoap.org/soap/encoding/",
            "stream_context"=>stream_context_create(
               array(
                 "ssl"=>array(
                     "verify_peer"        => true
                     ,"allow_self_signed" => false
                     ,"cafile"            => storage_path() . '/mycert.pam'
                     ,"verify_depth"      => 5
                     ,"CN_match"          => "http://schemas.xmlsoap.org/soap/encoding/"
                     )
                 )
             )
        ]);
        
        $json  = json_encode($sxe);
        $array = json_decode($json, TRUE);
        
        //dd($array);

        $response = $soapclient->__soapCall('ETM_DoAirFareRequest', $array);

        return view('main.search_page', [
            'title' => 'E-tickets',
        ]);
    }
}