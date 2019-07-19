<?php

define('TABNAME', 'wrk_mouvement');
require_once 'checker.php';

class Mouvement {

    public static function getPrises($idUtilisateur) {
        $columns = array('id_mouvement', 'id_utilisateur', 'heure_prise', 'code_emplacement', 'ref_produit', 'retry', 'type', 'groupe', 'commentaire');
        $subQuery = 'SELECT heure_prise FROM ' . TABNAME . ' t2 WHERE t2.ref_produit=t1.ref_produit';
        $clauseWhere = 'AND id_utilisateur="' . $idUtilisateur . '" AND type LIKE "prise" AND heure_prise>= ALL(' . $subQuery . ')';
        $prises = DBGetter::getColumns(TABNAME . ' t1', $columns, 'getPrises', 'id_mouvement', $clauseWhere);

        $ret = array();
        foreach ($prises as $prise) {
            $ret[] = array(
                'id' => $prise['id_mouvement'],
                'userId' => $prise['id_utilisateur'],
                'date' => $prise['heure_prise'],
                'gareId' => $prise['code_emplacement'],
                'groupname' => $prise['groupe'],
                'comment' => $prise['commentaire'],
                'itemId' => $prise['ref_produit'],
                'type' => $prise['type'],
                'retry' => $prise['retry']
            );
        }
        return json_encode($ret);
    }

    public static function addMouvements($listMouvements) {
        $nbAdded = 0;
        $nbIgnorer =0;
        $dataToSave = array();
        $createdAt = date('Y-m-d H:i:s');
        $groupItemToRemove = array();
        foreach ($listMouvements as $mouvement) {
            $idUtilisateur = $mouvement['userId'];
            if (!Checker::checkUser($idUtilisateur)) {
                return -1;
            }
            $date = $mouvement['date'];
            $gareId = $mouvement['gareId'];
            $group = $mouvement['groupname'];
            $comment = $mouvement['comment'];
            $itemId = $mouvement['itemId'];
            $retry = $mouvement['retry'];
            $type = $mouvement['method'];

            if ($type === 'depose') {
                $groupItemToRemove[] = '"'.$itemId.'"';
            }

            Checker::checkEmplacementAndInsert($gareId);
            if( !Checker::checkEmplacementAndProduitType($itemId,$gareId,$type)){
                $champs = array('id_utilisateur', 'heure_prise', 'ref_produit', 'code_emplacement', 'retry', 'type', 'groupe', 'commentaire', 'created_at');
                $valeurs = array($idUtilisateur, $date, $itemId, $gareId, $retry, $type, $group, $comment, $createdAt);

                $dataToSave[] = array('champs' => $champs, 'valeurs' => $valeurs);
            }else{
                $nbIgnorer++;
            }
        }
        $ids = DBSetter::creerElements(TABNAME, $dataToSave, 'addMouvements');
        if (count($groupItemToRemove) > 0) {
            DBSetter::supprimerElement('wrk_groupe', 'AND ref_produit IN (' . implode(',', $groupItemToRemove) . ')', 'addMouvements');
        }
        if ($ids && is_array($ids)) {
            $nbAdded = count($ids);
        }
        return $nbAdded+$nbIgnorer;
    }

}
