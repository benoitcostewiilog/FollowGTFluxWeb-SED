<?php
$moisText = '';
switch ($mois) {
    case '01':
        $moisText = 'Janvier';
        break;
    case '02':
        $moisText = 'Février';
        break;
    case '03':
        $moisText = 'Mars';
        break;
    case '04':
        $moisText = 'Avril';
        break;
    case '05':
        $moisText = 'Mai';
        break;
    case '06':
        $moisText = 'Juin';
        break;
    case '07':
        $moisText = 'Juillet';
        break;
    case '08':
        $moisText = 'Aout';
        break;
    case '09':
        $moisText = 'Septembre';
        break;
    case '10':
        $moisText = 'Octobre';
        break;
    case '11':
        $moisText = 'Novembre';
        break;
    case '12':
        $moisText = 'Décembre';
        break;
}
$moisText = $moisText . " " . $annee;
?>
<div class="ibox float-e-margins" id="ibox-schemaReception">
    <div class="ibox-title">
        <span class="label label-warning pull-right"><?php echo $moisText ?></span>
        <h5>Processus de réception</h5>
    </div>
    <div class="ibox-content">
        <div class="row">
            <div class="col-xs-6">
                <small class="stats-label">Arrivage</small>
                <h3><?php echo $nbArrivage ?></h3>
            </div>

            <div class="col-xs-6">
                <small class="stats-label">Arrivage en attente</small>
                <h3><?php echo $nbArrivageEnAttente ?></h3>
            </div>
        </div>
    </div>
    <div class="ibox-content">
        <div class="row">
            <div class="col-xs-6">
                <small class="stats-label">Réception non acheminée</small>
                <h3><?php echo $nbReceptionNonAchemine ?></h3>
            </div>

            <div class="col-xs-6">
                <small class="stats-label">Réception en retard</small>
                <h3><a onclick="$('#modalProduitRetard').modal('show');"><?php echo count($receptionEnRetard) ?></a></h3>
            </div>
        </div>
    </div>
    <div class="ibox-content">
        <div class="row">
            <div class="col-xs-12">
                <div class="text-center">
                    <h3>
                        <a id="precedent-schemaReception">
                            <i class="fa fa-arrow-circle-left fa-lg" style="color:#013972;"></i>
                        </a>
                        <?php echo $mois . "/" . $annee; ?>
                        <a id="suivant-schemaReception">
                            <i class="fa fa-arrow-circle-right fa-lg" style="color:#013972;"></i>
                        </a>
                    </h3>
                </div>
            </div>
        </div>
    </div>
    <div class="modal inmodal fade" id="modalProduitRetard" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only"><?php echo __('Fermer'); ?></span></button>
                    <h4 class="modal-title"><?php echo __('Numéro d’Arrivage en retard'); ?></h4>
                </div>
                <div class="modal-body">
                    <table class="table table-hover no-margins">
                        <thead>
                            <tr>
                                <th>Numéro d’Arrivage</th>
                                <th>Date de réception</th>
                                <th>Retard</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            include_partial('listRetard', array("produitEnRetard" => $receptionEnRetard));
                            ?>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button id="cancelButton" type="button" class="btn btn-white" data-dismiss="modal"><?php echo __('Fermer'); ?></button>
                </div>
            </div>
        </div>
    </div>
</div>
<script>

$(document).ready(function () {
    $('#precedent-schemaReception').click(function () {
        $.ajax({
            url: '<?php echo url_for('acceuil-reload-stats') ?>?type=schemaReception&annee=<?php echo $annee ?>&mois=<?php echo $mois - 1 ?>',
            success: function (data) {
            $('#modalProduitRetard').remove();
            $('#ibox-schemaReception').replaceWith(data);
            $('body').append($('#modalProduitRetard'));
            }
        });
    });
    $('#suivant-schemaReception').click(function () {
        $.ajax({
            url: '<?php echo url_for('acceuil-reload-stats') ?>?type=schemaReception&annee=<?php echo $annee ?>&mois=<?php echo $mois + 1 ?>',
            success: function (data) {
            $('#modalProduitRetard').remove();
            $('#ibox-schemaReception').replaceWith(data);
            $('body').append($('#modalProduitRetard'));
            }
        });
    });
});

</script>