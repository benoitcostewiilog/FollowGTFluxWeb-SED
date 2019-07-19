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
$inventaire = array();
$inventaire['method'] = 'inventaire';
$inventaire['userId'] = 1;
$inventaire['date'] = date('Y-m-d H:i:s');
$inventaire['gareId'] = 1;
$inventaire['itemId'] = 1;

$listInventaire = array();
$listInventaire[] = $inventaire;

$inventaire2 = array();
$inventaire2['method'] = 'inventaire';
$inventaire2['userId'] = 1;
$inventaire2['date'] = date('Y-m-d H:i:s');
$inventaire2['gareId'] = 1598;
$inventaire2['itemId'] = 'sdhshds454545sds';
$listInventaire[] = $inventaire2;
$paramJson = json_encode($listInventaire);
testService($adress, array(
    'sendData'
        ), array($paramJson),'inventaire');

