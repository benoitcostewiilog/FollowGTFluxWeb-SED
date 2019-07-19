<?php

define('TABNAME_EMPLACEMENT', 'ref_emplacement');
define('TABNAME_USER', 'sf_guard_user');
define('TABNAME_GROUP', 'wrk_groupe');
define('TABNAME_MOUVEMENT', 'wrk_mouvement');

class Checker {

    public static function checkEmplacementAndInsert($gareId) {
        $columns = array('code_emplacement');
        $emplacements = DBGetter::getColumns(TABNAME_EMPLACEMENT, $columns, 'checkEmplacementAndInsert', 'code_emplacement', 'AND code_emplacement="' . $gareId . '"');
        if (count($emplacements) == 0) {
            $champs = array('code_emplacement', 'libelle', 'created_at');
            $valeurs = array($gareId, $gareId, date('Y-m-d H:i:s'));
            return DBSetter::creerElement(TABNAME_EMPLACEMENT, $champs, $valeurs, 'checkEmplacementAndInsert');
        }
        return 0;
    }

    public static function checkUser($userId) {
        $columns = array('id');
        $users = DBGetter::getColumns(TABNAME_USER, $columns, 'checkUser', 'id', 'AND id="' . $userId . '"');
        if (count($users) == 0) {
            return false;
        }
        return true;
    }

    public static function checkGroupe($group, $itemId) {
        $columns = array('id_groupe');
        $users = DBGetter::getColumns(TABNAME_GROUP, $columns, 'checkGroupe', 'id_groupe', 'AND libelle="' . $group . '" AND ref_produit="'.$itemId.'"');
        if (count($users) == 0) {
            return false;
        }
        return true;
    }
    
    public static function checkEmplacementAndProduitType($itemId,$gareId,$type) {
        $columns = array('id_mouvement');
        $dateMax=date('Y-m-d', strtotime('-30 days'));
        $emplacements = DBGetter::getColumns(TABNAME_MOUVEMENT, $columns, 'checkEmplacementAndProduitType', 'code_emplacement', 'AND code_emplacement="' . $gareId . '" AND ref_produit="'.$itemId.'" AND type="'.$type.'" AND heure_prise > "'.$dateMax.'"');
        if (count($emplacements) > 0) {
            return true;
        }
        return false;
    }

}
