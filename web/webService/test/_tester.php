<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once '../lib/nusoap.php';
$adress = 'http://gtlogistics.local/webservice/';

function testService($adress, $method, $param,$methodName='') {
    $ws = new SoapClient($adress, array('trace' => 1));
    echo '<html><head></head><body><div>';
    $writer = function ( $tab) {
        echo '<table>';
        echo $tab;
        echo '</table>';
    };

    if (is_array($method)) {
        $i = 0;
        foreach ($method as $m) {
            echo "<div style=\"min-width: 300px; width: 33%;height: 33%;overflow: auto;border: 1px solid black;display: inline-block;\"><h2>$m ------- $methodName</h2>";
            try {
                $res = $ws->__soapCall($m, array($param[$i]));
                $writer($res);
            } catch (SoapFault $s) {
                $res = "Calling $m has failed ; here is the response\n" . $ws->__getLastResponse();
                echo $res;
            }
            echo '</div>';
            $i++;
        }
    } else {
        $res = $ws->__soapCall($method, array());
        $writer($res);
    }
    echo '</div></body></html>';
}
