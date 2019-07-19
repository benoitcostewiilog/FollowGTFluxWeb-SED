<table class="table table-striped table-bordered table-hover dataTables">
    <thead>
        <tr>
            <th><?php echo __('Code emplacement') ?></th>
            <th><?php echo __('Libelle') ?></th>
        </tr>
    </thead>
    <tbody>
        <?php $i=0; foreach ($ref_emplacements as $ref_emplacement) { $i++?>
            <tr id="emp-<?php echo $i ?>" emplacement="<?php echo $ref_emplacement->getCodeEmplacement() ?>" onmousedown="setIdClic(event, 'emp-<?php echo $i ?>');" class="context-menu-one box menu-1" >
                <td><?php echo $ref_emplacement->getCodeEmplacement() ?></td>
                <td><?php echo $ref_emplacement->getLibelle() ?></td>
            </tr>
        <?php } ?>
    </tbody>
    <tfoot>
        <tr>
            <th><?php echo __('Code emplacement') ?></th>
            <th><?php echo __('Libelle') ?></th>
        </tr>
    </tfoot>
</table>