<table class="table table-striped table-bordered table-hover dataTables">
    <thead>
        <tr>
            <th><?php echo __('Numéro du fournisseur') ?></th>
            <th><?php echo __('Libelle') ?></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($fournisseurs as $fournisseur) { ?>
            <tr id="<?php echo $fournisseur->getIdFournisseur() ?>" onmousedown="setIdClic(event, '<?php echo $fournisseur->getIdFournisseur() ?>');" class="context-menu-one box menu-1" >
                <td><?php echo $fournisseur->getIdFournisseur() ?></td>
                <td><?php echo $fournisseur->getLibelle() ?></td>
            </tr>
        <?php } ?>
    </tbody>
    <tfoot>
        <tr>
            <th><?php echo __('Numéro du fournisseur') ?></th>
            <th><?php echo __('Libelle') ?></th>
        </tr>
    </tfoot>
</table>