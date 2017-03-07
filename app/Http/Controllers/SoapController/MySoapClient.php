<?php

namespace App\Http\Controllers\SoapController;

class MySoapClient extends \SoapClient  {

    public function __doRequest($request, $location, $action, $version, $one_way = NULL) 
    {
        $new_request = explode("\n", $request, 2);
        $new_request = (isset($new_request[1])) ? $new_request[1] : $request;
        $new_request = str_replace("\n", '', $new_request);
        $new_request = trim($new_request);
        
        $result = parent::__doRequest($new_request, $location, $action, $version, $one_way); 
        
        return $new_request; 
    } 
}