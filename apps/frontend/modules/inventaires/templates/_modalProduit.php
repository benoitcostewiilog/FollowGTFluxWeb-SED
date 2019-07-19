<div class="modal inmodal fade" id="emplacement-<?php echo $codeEmplacement ?>-<?php echo strtotime($dateHeure) ?>-<?php echo $userId ?>" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only"><?php echo __('Fermer'); ?></span></button>
                <h4 class="modal-title"><?php echo __('Emplacement') . ' ' . $codeEmplacement; ?></h4>
                <h5><?php echo date('d/m/Y H:i:s', strtotime($dateHeure)); ?></h4>

            </div>
            <div class="modal-body">
                <div class="row">
                    <table class="table table-striped table-bordered table-hover dataTablesSimple" style="table-layout: fixed;" >
                        <thead>
                            <tr>
                                <th class="text-center"><?php echo __('Colis') ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($produits as $produit) { ?>
                                <tr>
                                    <td class="text-center"><?php echo $produit ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th class="text-center"><?php echo __('Colis') ?></th>
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