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
            <div class="col-xs-4">
                <small class="stats-label">Arrivage</small>
                <h3><a onclick="$('#modalArrivage').modal('show');"><?php echo count($nbArrivage) ?></a></h3>
            </div>

            <div class="col-xs-4">
                <small class="stats-label">Arrivage en attente</small>
                <h3><a onclick="$('#modalaRRIVAGEaTTENTE').modal('show');"><?php echo count($nbArrivageEnAttente) ?></a></h3>
            </div>
            
            <div class="col-xs-4">
                <small class="stats-label">Arrivage en retard</small>
                <h3><a onclick="$('#modalArrivageRetard').modal('show');"><?php echo count($arrivageEnRetard) ?></a></h3>
            </div>
        </div>
    </div>
    <div class="ibox-content">
        <div class="row">
            <div class="col-xs-4">
                <small class="stats-label">Réception non acheminée</small>
                <h3><a onclick="$('#modalReceptionNonAchemine').modal('show');"><?php echo count($nbReceptionNonAchemine) ?></a></h3>
            </div>

            <div class="col-xs-4">
                <small class="stats-label">Dépose</small>
                <h3><a onclick="$('#modalProduitRetard').modal('show');"><?php echo count($receptionEnRetard) ?></a></h3>
            </div>
             <div class="col-xs-4">
                <small class="stats-label">Mise en ligne</small>
                <h3><a onclick="$('#modalDeposeRetard').modal('show');"><?php echo count($deposeEnRetard) ?></a></h3>
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
                        <?php echo  $jour. "/" .$mois . "/" . $annee; ?>
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
                    <h4 class="modal-title"><?php echo __('Dépose'); ?></h4>
                </div>
                <div class="modal-body">
                    <table class="table table-hover no-margins">
                        <thead>
                            <tr>
                                <th>Numéro d’Arrivage</th>
                                  <th>Date d'arrivage</th>
                                <th>Date de réception</th>
                                
                                <th>Retard</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            include_partial('listRetardReception', array("produitEnRetard" => $receptionEnRetard));
                            ?>
                        </tbody>
                    </table>
                         <div class="m-t-md">
            <small class="pull-left" i>
                *Réceptions en retard = à l’instant T, les réceptions ayant dépassé le délai de 4h depuis l’heure d’arrivage avec une 1ère dépose après Réception.
            </small>
            <br>
        </div>
                </div>
                <div class="modal-footer">
                    <button id="cancelButton" type="button" class="btn btn-white" data-dismiss="modal"><?php echo __('Fermer'); ?></button>
                </div>
            </div>
        </div>
    </div>
    
        <div class="modal inmodal fade" id="modalArrivageRetard" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only"><?php echo __('Fermer'); ?></span></button>
                    <h4 class="modal-title"><?php echo __('Arrivage en retard'); ?></h4>
                </div>
                <div class="modal-body">
                    <table class="table table-hover no-margins">
                        <thead>
                            <tr>
                                <th>Numéro d’Arrivage</th>
                    <th>Date d'arrivage</th>
                    <th>Retard</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            include_partial('listarrivageRetard', array("listeArrivage" => $arrivageEnRetard));
                            ?>
                        </tbody>
                    </table>
                       <div class="m-t-md">
            <small class="pull-left" i>
                *Arrivages en retard = à l’instant T, les arrivages ayant dépassé le délai de 3h sans être passé en Réception.
            </small>
            <br>
        </div>
                </div>
                <div class="modal-footer">
                    <button id="cancelButton" type="button" class="btn btn-white" data-dismiss="modal"><?php echo __('Fermer'); ?></button>
                </div>
            </div>
        </div>
    </div>
         <div class="modal inmodal fade" id="modalDeposeRetard" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only"><?php echo __('Fermer'); ?></span></button>
                    <h4 class="modal-title"><?php echo __('Mise en ligne'); ?></h4>
                </div>
                <div class="modal-body">
                    <table class="table table-hover no-margins">
                        <thead>
                            <tr>
                                <th>Numéro d’Arrivage</th>
                                  <th>Date d'arrivage</th>
                                  <th>Date Reception</th>
                                    
                                <th>Retard</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            include_partial('listdeposeRetard', array("produitEnRetard" => $deposeEnRetard));
                            ?>
                        </tbody>
                   
                    </table>
                     <div class="m-t-md">
            <small class="pull-left" i>
                *Déposes en retard = à l’instant T, les Tracking n’ayant pas fait de 2e dépose après Réception avec un délai supérieur à 5,5h
            </small>
            <br>
        </div>
                </div>
                <div class="modal-footer">
                    <button id="cancelButton" type="button" class="btn btn-white" data-dismiss="modal"><?php echo __('Fermer'); ?></button>
                </div>
            </div>
        </div>
    </div>
    
           <div class="modal inmodal fade" id="modalReceptionNonAchemine" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only"><?php echo __('Fermer'); ?></span></button>
                    <h4 class="modal-title"><?php echo __('Réceptions non acheminées'); ?></h4>
                </div>
                <div class="modal-body">
                    <table class="table table-hover no-margins">
                        <thead>
                            <tr>
                                <th>Numéro d’Arrivage</th>
                                    <th>Date d'arrivage</th>
                                <th>Date de réception</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            include_partial('listReceptionNonAchemine', array("receptionNonAchemine" => $nbReceptionNonAchemine));
                            ?>
                        </tbody>
                    </table>
                            <div class="m-t-md">
            <small class="pull-left" i>
                *Réceptions non acheminées = à l’instant T les Réceptions qui n’ont pas fait une 1ère dépose après Réception.
            </small>
            <br>
        </div>
                </div>
                <div class="modal-footer">
                    <button id="cancelButton" type="button" class="btn btn-white" data-dismiss="modal"><?php echo __('Fermer'); ?></button>
                </div>
            </div>
        </div>
    </div>
    
         <div class="modal inmodal fade" id="modalaRRIVAGEaTTENTE" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only"><?php echo __('Fermer'); ?></span></button>
                    <h4 class="modal-title"><?php echo __('Arrivages en Attente'); ?></h4>
                </div>
                <div class="modal-body">
                    <table class="table table-hover no-margins">
                        <thead>
                            <tr>
                                <th>Numéro d'arrivage</th>
                                <th>Date d'arrivage</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            include_partial('listArrivageEnAttente', array("receptionNonAchemine" => $nbArrivageEnAttente));
                            ?>
                        </tbody>
                    </table>
                      <div class="m-t-md">
            <small class="pull-left" i>
                *Arrivages en Attente = à l’instant T, l’ensemble des Arrivages non réceptionnés (non associés avec un BR).
            </small>
            <br>
        </div>
                </div>
                <div class="modal-footer">
                    <button id="cancelButton" type="button" class="btn btn-white" data-dismiss="modal"><?php echo __('Fermer'); ?></button>
                </div>
            </div>
        </div>
    </div>
      
         <div class="modal inmodal fade" id="modalArrivage" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only"><?php echo __('Fermer'); ?></span></button>
                    <h4 class="modal-title"><?php echo __('Arrivages'); ?></h4>
                </div>
                <div class="modal-body">
                    <table class="table table-hover no-margins">
                        <thead>
                            <tr>
                                <th>Numéro d'arrivage</th>
                                <th>Date d'arrivage</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            include_partial('listArrivage', array("receptionNonAchemine" => $nbArrivage));
                            ?>
                        </tbody>
                    </table>
                      <div class="m-t-md">
            <small class="pull-left" i>
                *Arrivage = T0 déclenchement de la mesure du temps, liste des arrivages du jour.
            </small>
            <br>
        </div>
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
            url: '<?php echo url_for('acceuil-reload-stats') ?>?type=schemaReception&annee=<?php echo $annee ?>&mois=<?php echo $mois + 0 ?>&jour=<?php echo $jour - 1 ?>',
            success: function (data) {
            $('#modalProduitRetard').remove();
            $('#ibox-schemaReception').replaceWith(data);
            $('body').append($('#modalProduitRetard'));
            }
        });
    });
    $('#suivant-schemaReception').click(function () {
        $.ajax({
            url: '<?php echo url_for('acceuil-reload-stats') ?>?type=schemaReception&annee=<?php echo $annee ?>&mois=<?php echo $mois + 0 ?>&jour=<?php echo $jour + 1 ?>',
            success: function (data) {
            $('#modalProduitRetard').remove();
            $('#ibox-schemaReception').replaceWith(data);
            $('body').append($('#modalProduitRetard'));
            }
        });
    });
});

</script>