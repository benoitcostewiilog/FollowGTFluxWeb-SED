<table class="table table-striped table-bordered table-hover dataTables">
    <thead>
        <tr>
            <th><?php echo __('Numéro') ?></th>
            <th><?php echo __('Destinataire') ?></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($destinataires as $destinataire) { ?>
            <tr id="<?php echo $destinataire->getIdDestinataireAcheminement() ?>" onmousedown="setIdClic(event, '<?php echo $destinataire->getIdDestinataireAcheminement() ?>');" class="context-menu-one box menu-1" >
                <td><?php echo $destinataire->getIdDestinataireAcheminement() ?></td>
                <td><?php echo $destinataire->getDestinataire() ?></td>
            </tr>
        <?php } ?>
    </tbody>
    <tfoot>
        <tr>
            <th><?php echo __('Numéro') ?></th>
            <th><?php echo __('Destinataire') ?></th>
        </tr>
    </tfoot>
</table>