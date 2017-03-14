<?php

namespace App\Libs;

use App\Libs\Soap\EtmAbstract;

class Ping extends EtmAbstract
{
    public $echo_data = 'ping';
    
    public function getRequest()
    {
        return $this->echo_data;
    }
    
    public function call()
    {
        try
        {
            $response = $this->getSoapClient()->ETM_Ping($this->getRequest());
            
            return ($response == $this->echo_data)
                ? ['error' => false, 'response' => $response]
                : ['error' => true, 'response' => "Wrong response from ETM_Ping: $response"];
            
        } catch (\SoapFault $fault) {
            return ['error' => true, 'response' => $fault];
        }
    }
}