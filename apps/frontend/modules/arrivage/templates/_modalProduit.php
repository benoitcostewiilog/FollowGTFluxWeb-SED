<div class="modal inmodal fade modalProduit" id="produits-<?php echo $idArrivage ?>" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only"><?php echo __('Fermer'); ?></span></button>
                <?php
                $numArrivage = '';
                if (count($produits) > 0 && isset($produits[0]))
                    $numArrivage = substr($produits[0], 1, 12);
                ?>
                <h4 class="modal-title"><?php echo __('Arrivage n° ') . $numArrivage ?>
                    <a title="Imprimer le numéro d'arrivage" onclick="printNumArrivage('<?php echo $idArrivage ?>')"> <i class="fa fa-print"></i></a>
                </h4>

            </div>
            <div class="modal-body">
                <div class="row">
                    <table class="table table-striped table-bordered table-hover dataTablesSimple" style="table-layout: fixed;" >
                        <thead>
                            <tr>
                                <th class="text-center"><?php echo __('N° d\'arrivage') ?></th>
                                <th class="text-center"><?php echo __('Impression') ?> <a title="Imprimer les codes barres"  onclick="printCodesBarres('<?php echo $idArrivage ?>')"> <i class="fa fa-print"></i></a></th>
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
                                        <td class="text-center">
                                            <a title="Imprimer le code barre" onclick="printCodeBarre('<?php echo $produit ?>')"> <i class="fa fa-print"></i></a>
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
                                <th class="text-center"><?php echo __('Impression') ?></th>
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


<script>

    function printCodeBarre(produit) {
        $.post('<?php echo url_for('arrivages-print-codebarre') ?>?refProduit=' + produit, function (res) {
            options = {"closeButton": true, "progressBar": true, "positionClass": "toast-top-right"};
            if (res === '1') {
                toastr.success('L\'impression a été envoyée vers le serveur', 'Impression lancée', options);
            } else {
                toastr.error('Une erreur est survenue lors de l\'envoi vers le serveur', 'Echec de l\'impression', options);
            }


        });
    }
    function printCodesBarres(idArrivage) {
        $.post('<?php echo url_for('arrivages-print-codesbarres') ?>?idArrivage=' + idArrivage, function (res) {
            options = {"closeButton": true, "progressBar": true, "positionClass": "toast-top-right"};
            if (res === '1') {
                toastr.success('Les impressions ont été envoyées vers le serveur', 'Impressions lancées', options);
            } else {
                toastr.error('Une erreur est survenue lors de l\'envoi vers le serveur', 'Echec de l\'impression', options);
            }
        });
    }

    function printNumArrivage(idArrivage) {
        $.post('<?php echo url_for('arrivages-print-num') ?>?idArrivage=' + idArrivage, function (res) {
            options = {"closeButton": true, "progressBar": true, "positionClass": "toast-top-right"};
            if (res === '1') {
                toastr.success('L\'impression a été envoyée vers le serveur', 'Impression lancée', options);
            } else {
                toastr.error('Une erreur est survenue lors de l\'envoi vers le serveur', 'Echec de l\'impression', options);
            }


        });
    }
</script>