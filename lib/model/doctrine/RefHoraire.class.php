<?php

/**
 * RefHoraire
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    MobileStockV3
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class RefHoraire extends BaseRefHoraire {

    public static function getDays() {
        $days = array('Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche');
        return $days;
    }

}
