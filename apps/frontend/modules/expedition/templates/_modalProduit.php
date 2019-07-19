<div class="modal inmodal fade modalProduit" id="produits-<?php echo $idExpedition ?>" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only"><?php echo __('Fermer'); ?></span></button>
                <h4 class="modal-title"><?php echo __('Expedition n° ') . $expedition->getNumExpedition() ?>
                    <a title="Imprimer le numéro d'expedition" onclick="printNumExpedition('<?php echo $idExpedition ?>')"> <i class="fa fa-print"></i></a>
                </h4>
            </div>
            <div class="modal-body">
                <!--                <div class="row">
                                    <div class="text-center well">
                <?php echo __("Impression du numéro d'expedition : ") ?>
                                        <a title="Imprimer le numéro d'expedition" onclick="printNumExpedition('<?php echo $idExpedition ?>')"> <i class="fa fa-print fa-lg"></i></a>
                                    </div>
                                </div>-->
                <!--                <div class="row">
                                    <table class="table table-striped table-bordered table-hover dataTablesSimple" style="table-layout: fixed;" >
                                        <thead>
                                            <tr>
                                                <th class="text-center"><?php echo __('Colis') ?></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                <?php
                $produitAff = array();
                foreach ($produits as $produit) {
                    if (!in_array($produit, $produitAff)) {
                        $produitAff[] = $produit;
                        ?>
                                                                                    <tr>
                                                                                        <td class="text-center">
                        <?php echo $produit ?>
                                                                                        </td>
                                                                                    </tr>
                        <?php
                    }
                }
                ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th class="text-center"><?php echo __('Colis') ?></th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>-->
            </div>
            <div class="modal-footer">
                <button id="cancelButton" type="button" class="btn btn-white" data-dismiss="modal"><?php echo __('Fermer'); ?></button>
            </div>
        </div>
    </div>
</div>
<script>
    function printNumExpedition(idExp) {
        $.post('<?php echo url_for('expedition-print-num') ?>?idExpedition=' + idExp, function (res) {
            options = {"closeButton": true, "progressBar": true, "positionClass": "toast-top-right"};
            if (res === '1') {
                toastr.success('L\'impression a été envoyée vers le serveur', 'Impression lancée', options);
            } else {
                toastr.error('Une erreur est survenue lors de l\'envoi vers le serveur', 'Echec de l\'impression', options);
            }


        });
    }
</script>