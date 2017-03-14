<?php

namespace App\Libs;

use App\Libs\Soap\EtmAbstract;

class DoAirFareRequest extends EtmAbstract
{
    public $departure_datetime;
    public $original_location;
    public $destination_location;
    public $passangers_quantity;
    
    public function getRequest()
    {
        
        $xml = new \SimpleXMLElement('<AirFareRQ type="DoAirFareRQ"></AirFareRQ>');
        
        $this->addSecurityData($xml);

        
        $period_start = $xml->addChild('OriginDestinationInformation');
        $period_start->addAttribute('type', 'OriginDestinationInformationType');
        $period_start->addChild('DepartureDateTime', $this->departure_datetime);
        $period_start->addChild('OriginLocation', $this->original_location);
        $period_start->addChild('DestinationLocation', $this->destination_location);
        
        $traveler_adult = $xml->addChild('TravelerInfoSummary');
        $traveler_adult->addAttribute('type', 'TravelerInfoSummaryType');
        $traveler_adult->addChild('Quantity', $this->passangers_quantity);
        
        return $xml;
    }
    
    protected function getMethodName()
    {
        return 'ETM_DoAirFareRequest';
    }
}