<?php

define('TABNAME', 'wrk_groupe');
require_once 'checker.php';

class Groupe {

    public static function getGroupe($groupName) {
        $columns = array('libelle', 'id_utilisateur', 'date', 'ref_produit', 'retry');
        $clauseWhere = 'AND libelle="' . $groupName . '"';
        $groupe = DBGetter::getColumns(TABNAME, $columns, 'getGroupe', 'libelle', $clauseWhere);

        $ret = array();
        foreach ($groupe as $produit) {
            $ret[] = array(
                'id' => '',
                'userId' => $produit['id_utilisateur'],
                'date' => $produit['date'],
                'gareId' => '',
                'groupname' => $produit['libelle'],
                'comment' => '',
                'itemId' => $produit['ref_produit'],
                'type' => '',
                'retry' => $produit['retry']
            );
        }
        return json_encode($ret);
    }

    public static function addGroupes($listGroupes) {
        $nbAdded = 0;
        $dataToSave = array();
        $createdAt = date('Y-m-d H:i:s');
        $groupItemToRemove = array();

        //suppression de tous les produits du groupe
        if (count($listGroupes) > 0) {
            $firstGroup = $listGroupes[0];
            DBSetter::supprimerElement(TABNAME, 'AND libelle = "' . $firstGroup['groupname'] . '"', 'addGroupes');
        }

        foreach ($listGroupes as $groupe) {
            $itemId = $groupe['itemId'];
            if (isset($groupe['comment']) && $groupe['comment'] == 'delete') {
                $groupItemToRemove[] = '"' . $itemId . '"';
            } else {
                $idUtilisateur = 'NULL';
                if (isset($groupe['userId']) && $groupe['userId'] !== '') {
                    $idUtilisateur = $groupe['userId'];
                    if (!Checker::checkUser($idUtilisateur)) {
                        return -1;
                    }
                }
                $date = $groupe['date'];
                $group = $groupe['groupname'];
                $retry = $groupe['retry'];
                $champs = array('id_utilisateur', 'date', 'ref_produit', 'retry', 'libelle', 'created_at');
                $valeurs = array($idUtilisateur, $date, $itemId, $retry, $group, $createdAt);
                if (!Checker::checkGroupe($group, $itemId)) {
                    $res = DBSetter::supprimerElement(TABNAME, 'AND ref_produit IN ("' . $itemId . '")', 'addGroupes');
                }
                $dataToSave[] = array('champs' => $champs, 'valeurs' => $valeurs);
            }
        }

        if (count($dataToSave) > 0) {
            $ids = DBSetter::creerElements(TABNAME, $dataToSave, 'addGroupes');
            if ($ids && is_array($ids)) {
                $nbAdded = count($ids);
            }
        }
        if (count($groupItemToRemove) > 0) {
            $res = DBSetter::supprimerElement(TABNAME, 'AND ref_produit IN (' . implode(',', $groupItemToRemove) . ')', 'addGroupes');
            if ($res === 'Echec') {
                $nbAdded = -1;
            } else {
                $nbAdded += count($groupItemToRemove);
            }
        }

        return $nbAdded;
    }

}
