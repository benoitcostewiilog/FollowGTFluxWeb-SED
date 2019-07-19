<table id="Tacheminement" class="table table-striped table-bordered table-hover dataTables ">
    <thead>
        <tr>
            <th><?php echo __('N° acheminement') ?></th>
            <th><?php echo __('Nombre de  colis') ?></th>
            <th><?php echo __('Emplacement de prise') ?></th>
            <th><?php echo __('Emplacement de dépose') ?></th>
            <th><?php echo __('Date de la demande') ?></th>
            <th><?php echo __('Destinataire') ?></th>
            <th><?php echo __('Demandeur') ?></th>
            <th><?php echo __('Statut') ?></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($acheminements as $acheminement) { ?>
            <tr id="<?php echo $acheminement->getIdAcheminement() ?>" onmousedown="setIdClic(event, '<?php echo $acheminement->getIdAcheminement() ?>');" class="context-menu-one box menu-1" >
                <td><?php echo $acheminement->getNumAcheminement() ?></td>
                <td><?php echo $acheminement->getNbColis() ?></td>
                <td><?php echo ($acheminement->getRefEmplacementPrise() != null ? $acheminement->getRefEmplacementPrise()->getLibelle() : $acheminement->getCodeEmplacementPrise()) ?></td>
                <td><?php echo ($acheminement->getRefEmplacementDepose() != null ? $acheminement->getRefEmplacementDepose()->getLibelle() : $acheminement->getCodeEmplacementDepose()) ?></td>
                <td><?php echo date('d/m/Y H:i:s', strtotime($acheminement->getCreatedAt())) ?></td>
                <td><?php echo $acheminement->getDestinataire() ?></td>
                <td><?php echo $acheminement->getDemandeur() ?></td>
                <td><?php echo $acheminement->getStatut() ?></td>
            </tr>
        <?php } ?>
    </tbody>
    <tfoot>
        <tr>
            <th><?php echo __('N° acheminement') ?></th>
            <th><?php echo __('Nombre de colis') ?></th>
            <th><?php echo __('Emplacement de prise') ?></th>
            <th><?php echo __('Emplacement de dépose') ?></th>
            <th><?php echo __('Date de la demande') ?></th>
            <th><?php echo __('Destinataire') ?></th>
            <th><?php echo __('Demandeur') ?></th>
            <th><?php echo __('Statut') ?></th>
        </tr>
    </tfoot>
</table>