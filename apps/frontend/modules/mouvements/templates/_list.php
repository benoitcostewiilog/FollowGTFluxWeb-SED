<table class="table table-striped table-bordered table-hover dataTables display responsive no-wrap" width="100%" >
    <thead>
        <tr>
            <th><?php echo __('Numéro d’Arrivage'); ?></th>
            <th><?php echo __('Action'); ?></th>
            <th><?php echo __('Emplacement'); ?></th>
			 <th><?php echo __('Quantite'); ?></th>
            <th><?php echo __('Commentaire'); ?></th>
            <th><?php echo __('Groupe'); ?></th>
            <th><?php echo __('Date/Heure'); ?></th>
            <th><?php echo __('Utilisateur'); ?></th>
        </tr>
    </thead>
    <tbody>
        <?php
        /*
        $style = "";
        foreach ($mouvements as $mouvement):
            $action = $mouvement->getType();
            if (!is_null($mvtEnCours)) {
                if (in_array($mouvement->getIdMouvement(), $sf_data->getRaw('mvtEnCours'))) {
                    $style = "style=\"color:green;\"";
                    $action = 'prise non déposée';
                } else {
                    $style = "";
                }
            }
            ?>
            <tr <?php echo $style ?> id="<?php echo $mouvement->getIdMouvement() ?>" onmousedown="setIdClic(event, '<?php echo $mouvement->getIdMouvement() ?>');" class="context-menu-one box menu-1" >
                <td><?php echo $mouvement->getRefProduit() ?></td>
                <td><?php echo $action ?></td>
                <td><?php echo ($mouvement->getRefEmplacement() ? $mouvement->getRefEmplacement()->getLibelle() : $mouvement->getCodeEmplacement()) ?></td>
                <td><?php echo ($mouvement->getCommentaire() != "") ? $mouvement->getCommentaire() : 'N/C' ?></td>
                <td><?php echo $mouvement->getGroupe() ?></td>
                <td><?php echo date('d/m/Y H:i:s', strtotime($mouvement->getHeurePrise())) ?></td>
                <td><?php echo (isset($users[$mouvement->getIdUtilisateur()]) ? $users[$mouvement->getIdUtilisateur()] : $mouvement->getIdUtilisateur()) ?></td>
            </tr>
        <?php endforeach; */?>
    </tbody>
    <tfoot>
        <tr>
            <th><?php echo __('Numéro d’Arrivage'); ?></th>
            <th><?php echo __('Action'); ?></th>
            <th><?php echo __('Emplacement'); ?></th>
			 <th><?php echo __('Quantite'); ?></th>
            <th><?php echo __('Commentaire'); ?></th>
            <th><?php echo __('Groupe'); ?></th>
            <th><?php echo __('Date/Heure'); ?></th>
            <th><?php echo __('Utilisateur'); ?></th>
        </tr>
    </tfoot>
</table>