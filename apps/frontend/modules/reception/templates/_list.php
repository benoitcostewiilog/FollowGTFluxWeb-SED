<table class="table table-striped table-bordered table-hover dataTables ">
    <thead>
        <tr>
            <th><?php echo __('N° arrivage') ?></th>
            <th><?php echo __('N° reception') ?></th>
            <th><?php echo __('Date de création') ?></th>
            <th><?php echo __('Utilisateur'); ?></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($assBR as $uneAss) { ?>
            <tr id="<?php echo $uneAss->getIdArrivageProduit() ?>" onmousedown="setIdClic(event, '<?php echo $uneAss->getIdArrivageProduit() ?>');"  class="context-menu-one box menu-1">
                <td><?php echo $uneAss->getRefProduit() ?></td>
                <td><?php echo $uneAss->getBrSap() ?></td>
                <td><?php echo date('d/m/Y H:i:s',strtotime($uneAss->getCreatedAt())) ?></td>
                <td><?php echo (isset($users[$uneAss->getIdUtilisateur()]) ? $users[$uneAss->getIdUtilisateur()] : $uneAss->getIdUtilisateur()) ?></td>
            </tr>
        <?php } ?>
    </tbody>
    <tfoot>
        <tr>
            <th><?php echo __('N° arrivage') ?></th>
            <th><?php echo __('N° reception') ?></th>
            <th><?php echo __('Date de création') ?></th>
            <th><?php echo __('Utilisateur'); ?></th>
        </tr>
    </tfoot>
</table>