<?php
//Slot du titre de la page
slot('page_title', sprintf("Statistiques"));
?>

<div id="list-ajax-div">
    <div id="tpltLstHrchy" class="hidden">
        <ol class="breadcrumb">
            <li>
                <strong><a href="#"><?php echo __('Statistiques'); ?></a></strong>
            </li>
            <li class="active">
                <strong><?php echo __('Globales'); ?></strong>
            </li>

        </ol>
    </div>
    <div class="wrapper wrapper-content">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5><?php echo __('Filtrer les numéros d’Arrivage :') ?></h5>
                        <div class="ibox-tools">
                            <a class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                            </a>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <form id="formFiltre" action="<?php echo url_for('statistiques-get-stat') ?>" class="form-horizontal" method="POST">
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="row">
                                        <div class="form-group">
                                            <label class="col-lg-4 control-label"><?php echo __('Début'); ?></label>
                                            <div class="col-lg-8">
                                                <input id="filtreHeureDebut" value="<?php echo $heureDebut ?>" name="dateDebut" class="form-control dateFiltre"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-8 col-lg-offset-4">
                                            <div class="form-group">
                                                <button class="btn btn-primary" type="submit" style="margin-left: 11px;"><?php echo __('Filtrer'); ?></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="row">
                                        <div class="form-group">
                                            <label class="col-lg-4 control-label"><?php echo __('Fin'); ?></label>
                                            <div class="col-lg-8">
                                                <input id="filtreHeureFin" value="<?php echo $heureFin ?>" name="dateFin" class="form-control dateFiltre"/>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Globales</h5>
                    </div>
                    <div class="ibox-content">
                        <table id="tretard" class="table table-striped table-bordered table-hover dataTables display responsive no-wrap" width="100%" >
                            <thead>
                                <tr>
                                    <th><?php echo __('N° d\'arrivage'); ?></th>
                                    <th><?php echo __('Date arrivage'); ?></th>
                                    <th><?php echo __('Zone Attente'); ?></th>
                                    <th><?php echo __('Date dépose ZA'); ?></th>
                                    <th><?php echo __('Unités'); ?></th>
                                    <th><?php echo __('Réception'); ?></th>
                                    <th><?php echo __('zone Attente'); ?></th>
                                    <th><?php echo __('Date dépose ZA'); ?></th>
                                    <th><?php echo __('Date 1ere dépose'); ?></th>
                                    <th><?php echo __('Zone 1ere dépose'); ?></th>
                                    <th><?php echo __('Date dépose suivante'); ?></th>
                                    <th><?php echo __('Délais brute'); ?></th>
                                    <th><?php echo __('Délais'); ?></th>
                                    <th><?php echo __('retard'); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(isset($resultats)){
                                        $nbRes = count($resultats);
                                        for ($i = 0; $i < $nbRes; $i++) {
                                    ?>
                                    <tr>        
                                        <td class="click"><?php echo $resultats[$i]['num_arrivage'] ?></td>
                                        <td class="click"><?php echo $resultats[$i]['date_arrivage'] ?></td>
                                        <td class="click"><?php echo $resultats[$i]['zone_attente1'] ?></td>
                                        <td class="click"><?php echo $resultats[$i]['date_attente1'] ?></td>
                                        <td class="click"><?php echo $resultats[$i]['unite_tracking'] ?></td>
                                        <td class="click"><?php echo $resultats[$i]['date_reception'] ?></td>
                                        <td class="click"><?php echo $resultats[$i]['zone_attente2'] ?></td>
                                        <td class="click"><?php echo $resultats[$i]['date_attente2'] ?></td>
                                        <td class="click"><?php echo $resultats[$i]['date_depose'] ?></td>
                                        <td class="click"><?php echo $resultats[$i]['zone_depose'] ?></td>
                                        <td class="click"><?php echo $resultats[$i]['date_depose_suivante'] ?></td>
                                        <td class="click"><?php echo $resultats[$i]['delai_brut'] ?></td>
                                        <td class="click"><?php echo $resultats[$i]['delai'] ?></td>
                                        <td class="click"><?php echo $resultats[$i]['retard'] ?></td>
                                    </tr>
                                <?php 
                                        }
                                     }    ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th><?php echo __('N° d\'arrivage'); ?></th>
                                    <th><?php echo __('Date arrivage'); ?></th>
                                    <th><?php echo __('Zone Attente'); ?></th>
                                    <th><?php echo __('Date dépose ZA'); ?></th>
                                    <th><?php echo __('Unités'); ?></th>
                                    <th><?php echo __('Réception'); ?></th>
                                    <th><?php echo __('zone Attente'); ?></th>
                                    <th><?php echo __('Date dépose ZA'); ?></th>
                                    <th><?php echo __('Date 1ere dépose'); ?></th>
                                    <th><?php echo __('Zone 1ere dépose'); ?></th>
                                    <th><?php echo __('Date dépose suivante'); ?></th>
                                    <th><?php echo __('Délais brute'); ?></th>
                                    <th><?php echo __('Délais'); ?></th>
                                    <th><?php echo __('retard'); ?></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
$(document).ready(function () {
    $('#lytHrchy').html($('#tpltLstHrchy').html());
    $.fn.dataTable.moment('DD/MM/YYYY HH:mm:ss');
    var table = $('#tretard').DataTable({
    colReorder: true,
    stateSave: true,
     pageLength: 100,
    dom: '<<"#buttons"><"col-md-6"f>t<"col-md-4"l><"col-md-4"i><"col-md-4"p>>',
    "language": {
      "sProcessing":     "Chargement...",
      "sSearch":         "Rechercher&nbsp;:",
      "sLengthMenu":     "Afficher _MENU_ &eacute;l&eacute;ments",
      "sInfo":           "Affichage de l'&eacute;l&eacute;ment _START_ &agrave; _END_ sur _TOTAL_ &eacute;l&eacute;ments",
      "sInfoEmpty":      "Affichage de l'&eacute;l&eacute;ment 0 &agrave; 0 sur 0 &eacute;l&eacute;ment",
      "sInfoFiltered":   "(filtr&eacute; sur _MAX_ &eacute;l&eacute;ments au total)",
      "sInfoPostFix":    "",
      "sLoadingRecords": "Chargement en cours...",
      "sZeroRecords":    "Aucun &eacute;l&eacute;ment &agrave; afficher",
      "sEmptyTable":     "Aucune donn&eacute;e disponible dans le tableau",
      "oPaginate": {
          "sFirst":      "Premier",
          "sPrevious":   "Pr&eacute;c&eacute;dent",
          "sNext":       "Suivant",
          "sLast":       "Dernier'colvis'"
      },
      "oAria": {
          "sSortAscending":  ": activer pour trier la colonne par ordre croissant",
          "sSortDescending": ": activer pour trier la colonne par ordre d&eacute;croissant"
      },
      "buttons": {
        "copy": "Copier",
        "print": "Imprimer",
        "excel": "Export Excel",
        "csv": "Export CSV",
        "pdf": "Export PDF",
        "colvis": "Affichage des colonnes",
        "copyTitle": 'Ajouté au presse-papiers',
        "copySuccess": {
            _: '%d lignes ajoutées au presse-papiers',
            1: 'Une ligne ajoutée au presse-papiers'
        }
      },
    },
  });

    new $.fn.dataTable.Buttons(table, {
    buttons: [
        'copy',
        {
          extend: 'print',
          customize: function (win){
            $(win.document.body).addClass('white-bg');
            $(win.document.body).css('font-size', '10px');
            $(win.document.body).find('table').addClass('compact').css('font-size', 'inherit');
          }
        },
        {
          extend: 'excel',title: 'export_mouvement',
                    action: function (win) {
                       exporter("excel");
                    }
        },
        {
          extend: 'csv',title: 'export_mouvement'
        },
        {
          extend: 'pdf',title: 'export_mouvement'
        },
        'colvis'
      ]
    });

    var btns = table.buttons();
    var btncontainer = table.buttons().container();
    btncontainer.appendTo('#buttons');
    $('#buttons').addClass('col-md-6');
    $('#buttons').css({'padding': '0', 'margin-bottom': '6px'});
    $('#buttons').siblings().eq(0).css({'padding': '0', 'margin-bottom': '6px'});

    $('.dateFiltre').datetimepicker({
        format: 'DD/MM/YYYY HH:mm:ss',
        useCurrent: false,
        locale: moment.locale('fr'),
        icons: {time: 'fa fa-clock-o',date: 'fa fa-calendar',up: 'fa fa-chevron-up',down: 'fa fa-chevron-down',previous: 'fa fa-chevron-left',next: 'fa fa-chevron-right',today: 'fa fa-crosshairs',clear: 'fa fa-trash',close: 'fa fa-remove'}    
    });
    
    $("#filtreHeureDebut").on("dp.change", function (e) {
        $('#filtreHeureFin').data("DateTimePicker").minDate(e.date);
    });
    $("#filtreHeureFin").on("dp.change", function (e) {
        $('#filtreHeureDebut').data("DateTimePicker").maxDate(e.date);
    });

});


 function exporter(type) {
        url = '';
        switch (type) {
            case 'excel':
                url = '<?php echo url_for(array('sf_route' => 'statistiques-retard-excel')) ?>';
                break;
            case 'word':
               
                break;
            case 'print':
             
                break;
            case 'excelDelais':
                
                break;
            case 'csv':
              
                break;
        }
        debut = $('#filtreHeureDebut').val();
        fin = $('#filtreHeureFin').val();
        url = url + '?dateDebut=' + debut + '&dateFin=' + fin;
        location.assign(url);
    }


</script>