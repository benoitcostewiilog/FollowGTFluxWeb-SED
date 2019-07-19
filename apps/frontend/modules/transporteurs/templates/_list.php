<table class="table table-striped table-bordered table-hover dataTables ">
    <thead>
        <tr>
            <th><?php echo __('Numéro du transporteur') ?></th>
            <th><?php echo __('Libelle') ?></th>
            <th><?php echo __('Nb chauffeur') ?></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($transporteurs as $transporteur) { ?>
            <tr id="<?php echo $transporteur->getIdTransporteur() ?>" onclick="showChauffeurs('<?php echo $transporteur->getIdTransporteur() ?>')" onmousedown="setIdClic(event, '<?php echo $transporteur->getIdTransporteur() ?>');" class="context-menu-one box menu-1" >
                <td><?php echo $transporteur->getIdTransporteur() ?></td>
                <td><?php echo $transporteur->getLibelle() ?></td>
                <td><?php echo count($transporteur->getRefChauffeur()) ?></td>
            </tr>
        <?php } ?>
    </tbody>
    <tfoot>
        <tr>
            <th><?php echo __('Numéro du transporteur') ?></th>
            <th><?php echo __('Libelle') ?></th>
            <th><?php echo __('Nb chauffeur') ?></th>
        </tr>
    </tfoot>
</table>