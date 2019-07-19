<?php

define('DBHOST', 'localhost'); //Hôte du SGBD
define('DBUSER', 'root'); //User de connexion
define('DBPASS', ''); //Mot de passe de connexion
define('DBNAME', 'gt_log_tst_01'); //Nom de la base de données

define('LOGFILE', 'log.txt'); //Nom et/ou emplacement du fichier de log
define('NAMESP', 'urn'); //Namespace du Web Service

//Passage  la gestion par exception
function exception_error_handler($errno, $errstr, $errfile, $errline ) {
    Logger::log($errstr, Level::WARNING);
    throw new ErrorException($errstr, 0, $errno, $errfile, $errline);
}
set_error_handler("exception_error_handler");