<?php

namespace App\Libs;

use App\Libs\Soap\EtmAbstract;

class GetAirFareResult extends EtmAbstract
{
    public $request_id;
    
    public function getRequest()
    {
        $xml = new \SimpleXMLElement('<AirFareRQ type="GetAirFareRQ"></AirFareRQ>');
        
        $this->addSecurityData($xml);
        
        $xml->addChild('RequestId', $this->request_id);
        
        return $xml;
        
    }
    
    protected function getMethodName()
    {
        return 'ETM_GetAirFareResult';
    }
}