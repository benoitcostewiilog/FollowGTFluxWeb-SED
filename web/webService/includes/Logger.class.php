<?php

require_once(dirname(__FILE__).'/conf.inc.php');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Classe de log
 *
 * @author Florian
 */
class Logger
{

    /**
     * Logguer un évènement dans le fichier log.txt
     * @param type $text Le texte à logguer
     */
    public static function log($text, $level = Level::DEBUG)
    {
        $text = $level . " \t" . date("Y-m-d H:i:s", time()) . " - " .$text ;
        try{
            file_put_contents(LOGFILE, $text . "\r\n", FILE_APPEND);
        }
        catch(ErrorException $e){
            //Cannot write file !!
        }
    }

}

/**
 * Enumération des niveaux de gravité d'un log
 */
class Level
{
    const __default = self::DEBUG;
    
    const DEBUG = 'DEBUG';
    const INFO = 'INFO';
    const WARNING = 'WARNING';
    const ERROR = 'ERROR';
}
