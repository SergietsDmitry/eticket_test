<?php

namespace App\Libs;

use App\Libs\Soap\EtmAbstract;

class GetAirFareResult extends EtmAbstract
{
    public function getRequest()
    {
        
    }
    
    public function call()
    {
        try
        {
            $response = $this->getSoapClient()->ETM_GetAirFareResult($this->getRequest());
            
            return ['error' => false, 'response' => $response];
            
        } catch (\SoapFault $fault) {
            return ['error' => true, 'response' => $fault];
        }
    }
}