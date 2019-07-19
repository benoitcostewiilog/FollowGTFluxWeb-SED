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
$mouvement = array();
$mouvement['method'] = 'prise';
$mouvement['userId'] = 32;
$mouvement['date'] = date('Y-m-d H:i:s');
$mouvement['gareId'] = 1;
$mouvement['groupname'] = 'test';
$mouvement['comment'] = 'com test';
$mouvement['itemId'] = 1;
$mouvement['retry'] = 0;

$listMouvement = array();
$listMouvement[] = $mouvement;

$mouvement2 = array();
$mouvement2['method'] = 'prise';
$mouvement2['userId'] = 32;
$mouvement2['date'] = date('Y-m-d H:i:s');
$mouvement2['gareId'] = 1604;
$mouvement2['groupname'] = 'test';
$mouvement2['comment'] = 'com test';
$mouvement2['itemId'] = '11111111111';
$mouvement2['retry'] = 0;
$listMouvement[] = $mouvement2;

$mouvement3 = array();
$mouvement3['method'] = 'depose';
$mouvement3['userId'] = 32;
$mouvement3['date'] = date('Y-m-d H:i:s');
$mouvement3['gareId'] = 1605;
$mouvement3['groupname'] = '';
$mouvement3['comment'] = 'com test';
$mouvement3['itemId'] = '1111111111';
$mouvement3['retry'] = 0;
$listMouvement[] = $mouvement3;
$paramJson = json_encode($listMouvement);
testService($adress, array(
    'sendData'
        ), array($paramJson),'prise');

