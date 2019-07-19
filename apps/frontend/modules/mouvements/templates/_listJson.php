{
"draw": <?php echo $draw ?>,
"recordsTotal": <?php echo $mouvementsTotal ?>,
"recordsFiltered": <?php echo $mouvementsFiltrer ?>,
"data": [
<?php
$class = "";
$i = 0;
foreach ($mouvements as $mouvement):
    $action = $mouvement->getType();
    if (!is_null($mvtEnCours)) {
        if (in_array($mouvement->getIdMouvement(), $sf_data->getRaw('mvtEnCours'))) {
            $class = "context-menu-one box menu-1 nonDeposee";
            $action = 'prise non déposée';
        } else {
            $class = "context-menu-one box menu-1";
        }
    }
    ?>
    {
    "DT_RowId": "<?php echo $mouvement->getIdMouvement() ?>",
    "DT_RowClass": "<?php echo $class ?>",
    "reference": "<?php echo trim($mouvement->getRefProduit())?>",
    "action": "<?php echo $action ?>",
    "emplacement": "<?php echo ($mouvement->getRefEmplacement() ? $mouvement->getRefEmplacement()->getLibelle() : $mouvement->getCodeEmplacement()) ?>",
    "quantite": "<?php echo ($mouvement->getQuantite() != "") ? $mouvement->getQuantite() : '1' ?>",
    "commentaire": "<?php echo ($mouvement->getCommentaire() != "") ? $mouvement->getCommentaire() : 'N/C' ?>",
    "groupe": "<?php echo $mouvement->getGroupe() ?>",
    "date": "<?php echo date('d/m/Y H:i:s', strtotime($mouvement->getHeurePrise())) ?>",
    "arrivage": "<?php echo ($mouvement->getWrkArrivageProduit()) ? $mouvement->getWrkArrivageProduit()->getRefProduit() : 'Absent' ?>",
    "bl": "<?php echo ($mouvement->getWrkArrivageProduit() && $mouvement->getWrkArrivageProduit()->getWrkArrivage()) ? $mouvement->getWrkArrivageProduit()->getWrkArrivage()->getCommandeAchat() : 'Absent' ?>",
    "destinataire": "<?php echo ($mouvement->getWrkArrivageProduit() && $mouvement->getWrkArrivageProduit()->getWrkArrivage()) ? $mouvement->getWrkArrivageProduit()->getWrkArrivage()->getRefContactPFF()->getNom() : 'Absent' ?>",
    "signature": "<?php echo ($mouvement->getSignature() && strlen($mouvement->getSignature())>10) ? "<a onclick='showSignature(this)' class='signature' data='" . $mouvement->getSignature() . "'><i class='fa fa-file-image-o'></i></a>" : 'N/C' ?>",
    "photos": "<?php echo ($mouvement->getPhotos() && strlen($mouvement->getPhotos())>10) ? "<a onclick='showPhotos(this)' class='photos' data='" . $mouvement->getPhotos() . "'><i class='fa fa-file-image-o'></i></a>" : 'N/C' ?>",
    "utilisateur": "<?php echo (isset($users[$mouvement->getIdUtilisateur()]) ? $users[$mouvement->getIdUtilisateur()] : $mouvement->getIdUtilisateur()) ?>"
    }<?php echo $i == (count($mouvements) - 1) ? "" : "," ?>

    <?php
    $i++;
endforeach;
?>
]
}