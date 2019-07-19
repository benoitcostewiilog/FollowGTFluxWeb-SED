<?php

class RefTransporteurTable extends Doctrine_Table {

    public static function getInstance() {
        return Doctrine_Core::getTable('RefTransporteur');
    }

    /* transforme une collection de transporteur en tableau tri� par ordre alaphabetique	 */

    public static function toTable($collection, $blanc = false, $sansCode = false) {
        if ($blanc)
            $object_table = array(null => null);
        else
            $object_table = array();
        foreach ($collection as $object):
            if ($sansCode)
                $object_table[strval($object->getCodeTransp())] = $object->getDesigTransp();
            else
                $object_table[strval($object->getCodeTransp())] = $object->getCodeTransp() . " - " . $object->getDesigTransp();
        endforeach;
        return $object_table;
    }

    /* renvoi une instance du formulaire de cette table */

    public static function getForm($instance = null) {
        return new RefTransporteurForm($instance);
    }

    /* retourne tous les transporteur sous forme de tableau */

    public static function getTableauTransporteur($blanc = false) {
        $q = Doctrine_Query::create()->from('RefTransporteur r');
        //retourne la collection sous forme de tableau avec un blanc au debut
        return self::toTable($q->execute(), $blanc, true);
    }

    public static function getListeTransp() {
        $requete = "SELECT * FROM ref_transporteur rt
				WHERE 1=1";

        $resultat = Doctrine_Manager::getInstance()->getConnection('doctrine')->getDbh()->query($requete)->fetchAll();

        return $resultat;
    }

}
