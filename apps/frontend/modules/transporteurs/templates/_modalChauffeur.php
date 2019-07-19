<div class="modal inmodal fade" id="transporteur-<?php echo $transporteur->getIdTransporteur() ?>" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only"><?php echo __('Fermer'); ?></span></button>
                <h4 class="modal-title"><?php echo __('Listes des chauffeurs'); ?></h4>
                <h4><?php echo $transporteur->getLibelle() ?></h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <table class="table table-striped table-bordered table-hover dataTablesSimple" style="table-layout: fixed;" >
                        <thead>
                            <tr>
                                <th class="text-center"><?php echo __('Nom') ?></th>
                                <th class="text-center"><?php echo __('Prénom') ?></th>
                                <th class="text-center"><?php echo __('Document ID') ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($transporteur->getRefChauffeur() as $chauffeur) { ?>
                                <tr>
                                    <td class="text-center"><?php echo $chauffeur->getNom() ?></td>
                                    <td class="text-center"><?php echo $chauffeur->getPrenom() ?></td>
                                    <td class="text-center"><?php echo $chauffeur->getNumDocId() ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th class="text-center"><?php echo __('Nom') ?></th>
                                <th class="text-center"><?php echo __('Prénom') ?></th>
                                <th class="text-center"><?php echo __('Document ID') ?></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button id="cancelButton" type="button" class="btn btn-white" data-dismiss="modal"><?php echo __('Fermer'); ?></button>
            </div>
        </div>
    </div>
</div>