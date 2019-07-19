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
$mouvement['method'] = 'group';
$mouvement['userId'] = '';
$mouvement['date'] = date('Y-m-d H:i:s');
$mouvement['groupname'] = 'test';
$mouvement['itemId'] = 'azerty';
$mouvement['comment'] = '';
$mouvement['retry'] = 0;

$listMouvement = array();
$listMouvement[] = $mouvement;

$mouvement2 = array();
$mouvement2['method'] = 'group';
$mouvement2['userId'] = '';
$mouvement2['date'] = date('Y-m-d H:i:s');
$mouvement2['groupname'] = 'test';
$mouvement2['comment'] = 'delete';
$mouvement2['itemId'] = 'azerty';
$mouvement2['retry'] = 0;
$listMouvement[] = $mouvement2;

$paramJson = json_encode($listMouvement);
testService($adress, array(
    'sendData'
        ), array($paramJson),'group');

