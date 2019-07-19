<table class="table table-striped table-bordered table-hover dataTables">
    <thead>
        <tr>
            <th><?php echo __('Numéro') ?></th>
            <th><?php echo __('Nom') ?></th>
            <th><?php echo __('Prénom') ?></th>
            <th><?php echo __('Mail') ?></th>
            <th><?php echo __('Emplacement') ?></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($interlocuteurs as $interlocuteur) { ?>
            <tr id="<?php echo $interlocuteur->getId() ?>" onmousedown="setIdClic(event, '<?php echo $interlocuteur->getId() ?>');" class="context-menu-one box menu-1" >
                <td><?php echo $interlocuteur->getId() ?></td>
                <td><?php echo $interlocuteur->getNom() ?></td>
                <td><?php echo $interlocuteur->getPrenom() ?></td>
                <td><?php echo $interlocuteur->getMail() ?></td>
                <td><?php echo $interlocuteur->getRefEmplacement()->getCodeEmplacement() ?></td>
            </tr>
        <?php } ?>
    </tbody>
    <tfoot>
        <tr>
            <th><?php echo __('Numéro') ?></th>
            <th><?php echo __('Nom') ?></th>
            <th><?php echo __('Prénom') ?></th>
            <th><?php echo __('Mail') ?></th>
            <th><?php echo __('Emplacement') ?></th>
        </tr>
    </tfoot>
</table>