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
        $xml = new \SimpleXMLElement('<AirFareRQ type="DoAirFareRQ"></AirFareRQ>');
        
        $security = $xml->addChild('Security');
        $security->addAttribute('type', 'SecurityType');
        $security->addChild('Username', 'test');
        $security->addChild('Password', 'b4ApBWIaD9qK');
        $security->addChild('HashKey', 'a1601fb45b');
        
        $period_start = $xml->addChild('OriginDestinationInformation');
        $period_start->addAttribute('type', 'OriginDestinationInformationType');
        $period_start->addChild('DepartureDateTime', date('Y-m-d H:i:s', strtotime('2014-08-16 00:00:00')));
        $period_start->addChild('OriginLocation', 'MOW');
        $period_start->addChild('DestinationLocation', 'MUC');
        
        $period_end = $xml->addChild('OriginDestinationInformation');
        $period_end->addAttribute('type', 'OriginDestinationInformationType');
        $period_end->addChild('DepartureDateTime', date('Y-m-d H:i:s', strtotime('2014-08-16 00:00:00')));
        $period_end->addChild('OriginLocation', 'MUC');
        $period_end->addChild('DestinationLocation', 'MOW');
        
        $traveler_adult = $xml->addChild('TravelerInfoSummary');
        $traveler_adult->addAttribute('type', 'TravelerInfoSummaryType');
        $traveler_adult->addChild('Type', 'ADT');
        $traveler_adult->addChild('Quantity', 1);
        
        $traveler_child = $xml->addChild('TravelerInfoSummary');
        $traveler_child->addAttribute('type', 'TravelerInfoSummaryType');
        $traveler_child->addChild('Type', 'CHD');
        $traveler_child->addChild('Quantity', 1);
        
        $preferences = $xml->addChild('TravelPreferences');
        $preferences->addAttribute('type', 'TravelPreferencesType');
        $preferences->addChild('VendorPref', 'LH');
        $preferences->addChild('BookingClassPref', 'E');
        $preferences->addChild('OnlyDirectPref', true);
        
        $stream_context = stream_context_create([
            'ssl' => [
                'verify_peer'       => false,
                'verify_peer_name'  => false,
                'allow_self_signed' => true,
                'ciphers'           => "SHA1"
            ]
        ]);
        
        $soapclient = new \SoapClient("http://roman.etm-system.de/etm-system/etm-webservice-0.3.1/server.php?WSDL", [
            "location"       =>"http://roman.etm-system.de/etm-system/etm-webservice-0.3.1/server.php",
            "trace"          => true,
            "exception"      => true,
            "local_cert"     => storage_path() . '/mycert.pam',
            'stream_context' => $stream_context,
            'soap_version'   => SOAP_1_1
        ]);
        
        try
        {
            $response = $soapclient->ETM_DoAirFareRequest($xml);
        } catch (\SoapFault $ex) {
             //dd($ex);
        }
        
        dd($soapclient->__getLastResponse(), $soapclient->__getLastResponseHeaders(), $soapclient->__getLastRequest(), $soapclient->__getLastRequestHeaders());
        
        return view('main.search_page', [
            'title' => 'E-tickets',
        ]);
    }
}