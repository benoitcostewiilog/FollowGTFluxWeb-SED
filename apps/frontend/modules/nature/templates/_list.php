<table class="table table-striped table-bordered table-hover dataTables ">
    <thead>
        <tr>
            <th><?php echo __('Libelle') ?></th>
            <th><?php echo __('Delais maximum') ?></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($natures as $nature) { ?>
            <tr id="<?php echo $nature->getIdNature() ?>" onmousedown="setIdClic(event, '<?php echo $nature->getIdNature() ?>');" class="context-menu-one box menu-1" >
                <td><?php echo $nature->getLibelle() ?></td>
                <td><?php echo $nature->getDelais() ?></td>
            </tr>
        <?php } ?>
    </tbody>
    <tfoot>
        <tr>
            <th><?php echo __('Libelle') ?></th>
            <th><?php echo __('Delais maximum') ?></th>
        </tr>
    </tfoot>
</table>