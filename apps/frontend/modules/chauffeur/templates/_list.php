<table class="table table-striped table-bordered table-hover dataTables">
    <thead>
        <tr>
            <th><?php echo __('Nom') ?></th>
            <th><?php echo __('Prénom') ?></th>
            <th><?php echo __('Document ID') ?></th>
            <th><?php echo __('Transporteur') ?></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($ref_chauffeurs as $ref_chauffeur) { ?>
            <tr id="<?php echo $ref_chauffeur->getIdChauffeur() ?>" onmousedown="setIdClic(event, '<?php echo $ref_chauffeur->getIdChauffeur() ?>');" class="context-menu-one box menu-1" >
                <td><?php echo $ref_chauffeur->getNom() ?></td>
                <td><?php echo $ref_chauffeur->getPrenom() ?></td>
                <td><?php echo $ref_chauffeur->getNumDocId() ?></td>
                <td><?php echo $ref_chauffeur->getRefTransporteur()->getLibelle() ?></td>
            </tr>
        <?php } ?>
    </tbody>
    <tfoot>
        <tr>
            <th><?php echo __('Nom') ?></th>
            <th><?php echo __('Prénom') ?></th>
            <th><?php echo __('Document ID') ?></th>
            <th><?php echo __('Transporteur') ?></th>
        </tr>
    </tfoot>
</table>