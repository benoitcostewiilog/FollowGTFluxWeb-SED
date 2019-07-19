<?php

//En-tête des web-services
require_once dirname(__FILE__) . '/../lib/nusoap.php';
require_once dirname(__FILE__) . '/conf.inc.php';
require_once dirname(__FILE__) . '/DBGetter.class.php';
require_once dirname(__FILE__) . '/DBSetter.class.php';

$server = new soap_server();

// Initialize WSDL support
$namespace = (defined('NAMESP') ? NAMESP : 'urn') . ':' . WSDL;
$server->configureWSDL(WSDL, $namespace);
