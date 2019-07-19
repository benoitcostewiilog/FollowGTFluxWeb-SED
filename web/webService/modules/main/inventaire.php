<?php

define('TABNAME', 'wrk_inventaire');
require_once 'checker.php';

class Inventaire {

    public static function addInventaires($inventaires) {
        $nbAdded = 0;
        $dataToSave = array();
        $createdAt = date('Y-m-d H:i:s');
        foreach ($inventaires as $inventaire) {
            $idUtilisateur = $inventaire['userId'];
            if (!Checker::checkUser($idUtilisateur)) {
                return -1;
            }
            $date = $inventaire['date'];
            $gareId = $inventaire['gareId'];
            $itemId = $inventaire['itemId'];
            Checker::checkEmplacementAndInsert($gareId);
            $champs = array('id_utilisateur', 'heure_prise', 'ref_produit', 'code_emplacement', 'created_at');
            $valeurs = array($idUtilisateur, $date, $itemId, $gareId, $createdAt);

            $dataToSave[] = array('champs' => $champs, 'valeurs' => $valeurs);
        }
        $ids = DBSetter::creerElements(TABNAME, $dataToSave, 'addInventaires');
        if ($ids && is_array($ids)) {
            $nbAdded = count($ids);
        }
        return $nbAdded;
    }

}
