<?php

namespace App\Libs;

use App\Libs\Soap\EtmAbstract;

class DoAirFareRequest extends EtmAbstract
{
    public function getRequest()
    {
        $xml = new \SimpleXMLElement('<AirFareRQ type="DoAirFareRQ"></AirFareRQ>');
        
        $this->addSecurityData($xml);
        
        $period_start = $xml->addChild('OriginDestinationInformation');
        $period_start->addAttribute('type', 'OriginDestinationInformationType');
        $period_start->addChild('DepartureDateTime', date("Y-m-d\TH:i:s", strtotime('2014-08-16 00:00:00')));
        $period_start->addChild('OriginLocation', 'MOW');
        $period_start->addChild('DestinationLocation', 'MUC');
        
        $period_end = $xml->addChild('OriginDestinationInformation');
        $period_end->addAttribute('type', 'OriginDestinationInformationType');
        $period_end->addChild('DepartureDateTime', date("Y-m-d\TH:i:s", strtotime('2014-08-16 00:00:00')));
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
        
        return $xml;
    }
    
    public function call()
    {
        try
        {
            $response = $this->getSoapClient()->ETM_DoAirFareRequest($this->getRequest());
            
            return ['error' => false, 'response' => $response];
            
        } catch (\SoapFault $fault) {
            return ['error' => true, 'response' => $fault];
        }
    }
}