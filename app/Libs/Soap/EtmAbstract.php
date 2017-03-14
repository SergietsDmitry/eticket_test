<?php

namespace App\Libs\Soap;

use App\Libs\Soap\MySoapClient;

abstract class EtmAbstract
{
    private $soap_client;

    public function __construct()
    {
        $stream_context = stream_context_create([
            'ssl' => [
                'verify_peer'       => false,
                'verify_peer_name'  => false,
                'allow_self_signed' => true,
                'ciphers'           => "RC4-SHA"
            ]
        ]);
        
        $this->soap_client = new MySoapClient("http://roman.etm-system.de/etm-system/etm-webservice-0.3.1/server.php?WSDL", [
            "location"       =>"http://roman.etm-system.de/etm-system/etm-webservice-0.3.1/server.php",
            "trace"          => true,
            "exception"      => true,
            "local_cert"     => storage_path() . '/mycert.pam',
            'stream_context' => $stream_context,
            'soap_version'   => SOAP_1_1
        ]);
    }
    
    public function addSecurityData(&$xml)
    {
        $security = $xml->addChild('Security');
        $security->addAttribute('type', 'SecurityType');
        $security->addChild('Username', 'test');
        $security->addChild('Password', 'b4ApBWIaD9qK');
        $security->addChild('HashKey', 'a1601fb45b');
        
        return $security;
    }
    
    public function getSoapClient()
    {
        return isset($this->soap_client)
            ? $this->soap_client
            : new MySoapClient();
    }

    public function call()
    {
        try
        {
            $method_name = $this->getMethodName();
            $response = $this->getSoapClient()->$method_name($this->getRequest());
            
            if (isset($response->Errors))
            {
                return [
                    'error'    => true,
                    'code'     => $response->Errors->Code ?? 0,
                    'response' => $response->Errors->Message ?? ''];
            }
            
            return ['error' => false, 'response' => $response];
            
        } catch (\SoapFault $fault) {
            //return ['error' => true, 'response' => $fault];
            return ['error' => true, 'response' => 'Bad request!'];
        }
    }
    
    abstract public function getRequest();
    abstract protected function getMethodName();
}
