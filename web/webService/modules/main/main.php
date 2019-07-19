<?php

define('WSDL', 'mainwsdl');
require_once '../../includes/head_content.inc.php';


DBGetter::registerGetter($server, WSDL, 'getData', 'Recuperation de donnees', array('data' => 'xsd:string'));

function getData($data) {
    $data = json_decode($data, true);

    if ($data && isset($data['method'])) {
        switch ($data['method']) {
            case 'getUsers':
                require_once 'users.php';
                return User::getUsers();
            case 'getGare':
                require_once 'emplacement.php';
                return Emplacement::getEmplacements();
            case 'getPrise':
                if ($data['arg1'] && $data['arg1'] != '') {
                    require_once 'mouvement.php';
                    return Mouvement::getPrises($data['arg1']);
                }
                return false;
            case 'getGroup':
                if ($data['arg1'] && $data['arg1'] != '') {
                    require_once 'groupe.php';
                    return Groupe::getGroupe($data['arg1']);
                }
                return false;
            case 'getTime':
                return date('Y-m-d H:i:s');
        }
    }
    return false;
}

DBSetter::registerSetter($server, WSDL, 'sendData', 'Envoi de donnees', array('data' => 'xsd:string'));

function sendData($data) {
    $data = json_decode($data, true);
    if (is_array($data) && count($data) > 0) {
        if ($data[0]['method'] == 'inventaire') {
            require_once 'inventaire.php';
            return Inventaire::addInventaires($data);
        } else if ($data[0]['method'] == 'group') {
            require_once 'groupe.php';
            return Groupe::addGroupes($data);
        } else {
            require_once 'mouvement.php';
            return Mouvement::addMouvements($data);
        }
    }
    return false;
}

$HTTP_RAW_POST_DATA = isset($HTTP_RAW_POST_DATA) ? $HTTP_RAW_POST_DATA : '';
$server->service($HTTP_RAW_POST_DATA);
