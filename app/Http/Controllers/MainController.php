<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\SoapController\MySoapClient;

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
        
        //$xml_new = explode("\n", $xml->asXML(), 2)[1];
        
        $stream_context = stream_context_create([
            'ssl' => [
                'verify_peer'       => false,
                'verify_peer_name'  => false,
                'allow_self_signed' => true,
                'ciphers'           => "RC4-SHA"
            ]
        ]);
        
        $soap_client = new MySoapClient("http://roman.etm-system.de/etm-system/etm-webservice-0.3.1/server.php?WSDL", [
            "location"       =>"http://roman.etm-system.de/etm-system/etm-webservice-0.3.1/server.php",
            "trace"          => true,
            "exception"      => true,
            "local_cert"     => storage_path() . '/mycert.pam',
            'stream_context' => $stream_context,
            'soap_version'   => SOAP_1_1
        ]);
        
        //$soap_client->__setSoapHeaders(NULL); 
        
        //$xmlVar = simplexml_load_string($xml_new);
        
        try
        {
            $response = $soap_client->ETM_DoAirFareRequest($xml, false);
        } catch (\SoapFault $ex) {
             //dd($ex);
        }
        
            //$xml_new = explode("\n", $soap_client->__getLastRequest(), 2)[1];
            
            //dd($soapclient->__getLastRequest(), $xml_new);
            
        dd($soap_client->__getLastResponse(), $soap_client->__getLastResponseHeaders(), $soap_client->__getLastRequest(), $soap_client->__getLastRequestHeaders());
        
        return view('main.search_page', [
            'title' => 'E-tickets',
        ]);
    }
}