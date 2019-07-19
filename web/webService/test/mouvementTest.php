<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


require_once './_tester.php';
define('WSDL', 'mainwsdl');
require_once '../includes/head_content.inc.php';
$adress .= 'modules/main/main.php?wsdl';

$param = array('method' => 'getPrise', 'arg1' => '1');
$paramJson = json_encode($param);
testService($adress, array(
    'getData'
        ), array($paramJson));

