<?php

class RefFournisseurTable extends Doctrine_Table {

    public static function getInstance() {
        return Doctrine_Core::getTable('RefFournisseur');
    }

    /* transforme une collection de fournisseur en tableau tri� par ordre alaphabetique	 */

    public static function toTable($collection, $blanc = false) {
        if ($blanc)
            $object_table = array(null => null);
        else
            $object_table = array();
        foreach ($collection as $object):
            $object_table[strval($object->getCodeFour())] = $object->getCodeFour() . " - " . $object->getNomRaccourcie(10);
        endforeach;
        return $object_table;
    }

    /* renvoi une instance du formulaire de cette table */

    public static function getForm($instance = null) {
        return new RefFournisseurForm($instance);
    }

    /* retourne la liste des fournisseur actif  sous forme de tablea	 */

    public static function getFournisseurActif($blanc = false) {
        $q = Doctrine_Query::create()->From('RefFournisseur r')->where('r.actif = 1');
        return self::toTable($q->execute(), $blanc);
    }

    /* retourne la liste des fournisseur actif  sous forme de tablea	 */

    public static function getTableauFournisseur($blanc = false) {
        $q = Doctrine_Query::create()->From('RefFournisseur r');
        return self::toTable($q->execute(), $blanc);
    }

    /* retourne la liste des fournisseur actif sous forme de colection 	 */

    public static function getFournisseursEnActivite() {
        $q = Doctrine_Query::create()->From('RefFournisseur r')
                ->innerJoin('r.RefCommandeFour rcf');
        //	->where('r.actif = 1');
        return $q->execute();
    }

    /* retourne un fournisseur a partir de son nom 	 */

    public static function getFournisseurParNom($fournisseur) {
        $resultat = Doctrine_Query::create()->From('RefFournisseur r')
                        ->where('r.designation_four = ?', $fournisseur)->execute();
        //on a besoin d'un objet et pas d'une collec donc on renvoie le premier, on test qd si on a un r�sultat...
        if ($resultat->count()) {
            return $resultat->getFirst();
        } else {
            return null;
        }
    }

    /* retourne un fournisseur a partir du tableau CODE_FOUR - DESIGNATION_FOUR 	 */

    public static function getFournisseurParTableau($fournisseur) {
        $explode = explode(" - ", $fournisseur);
        $codeFour = $explode[0];
        $resultat = Doctrine_Query::create()->From('RefFournisseur r')
                        ->where('r.code_four = ?', $codeFour)->execute();
        //on a besoin d'un objet et pas d'une collec donc on renvoie le premier, on test qd si on a un r�sultat...
        if ($resultat->count()) {
            return $resultat->getFirst();
        } else {
            return null;
        }
    }

}
