<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Debug {

    function dumpData($data)
    {
    	print '<pre>' . print_r($data, 1) . '</pre>';
    }
}

?>