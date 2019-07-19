<?php
slot('page_title', sprintf("Inventaires"));
?>
<div id="list-ajax-div">
    <div id="tpltLstHrchy" class="hidden">
        <ol class="breadcrumb">
            <li>
                <a href="#"><?php echo __('Inventaires'); ?></a>
            </li>
            <li class="active">
                <strong><?php echo __('Liste'); ?></strong>
            </li>
        </ol>
    </div>
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5><?php echo __('Filtrer les inventaires :') ?></h5>
                        <div class="ibox-tools">
                            <a class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                            </a>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <form id="formFiltre" action="<?php echo url_for('inventaires') ?>" class="form-horizontal" method="POST">
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="row">
                                        <div class="form-group">
                                            <label class="col-lg-4 control-label"><?php echo __('Début'); ?></label>
                                            <div class="col-lg-8">
                                                <input id="heureDebut" value="<?php echo $heureDebut ?>" name="heureDebut" class="form-control dateFiltre"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group">
                                            <label class="col-lg-4 control-label"><?php echo __('Fin'); ?></label>
                                            <div class="col-lg-8">
                                                <input id="heureFin" value="<?php echo $heureFin ?>" name="heureFin" class="form-control dateFiltre"/>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="row">
                                        <div class="form-group">
                                            <label class="col-lg-4 control-label"><?php echo __('Emplacement'); ?></label>
                                            <div class="col-lg-8">
                                                <select id="emplacement" name="emplacement" class="form-control" data-placeholder=" ">
                                                    <option value="">Aucun</option>
                                                    <?php foreach ($emplacements as $value) { ?>
                                                        <option <?php echo ($value->getCodeEmplacement() == $emplacement ? 'selected' : '') ?> value="<?php echo $value->getCodeEmplacement() ?>"><?php echo $value->getLibelle() ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-8 col-lg-offset-4">
                                            <div class="form-group">
                                                <button class="btn btn-primary" type="submit"><?php echo __('Filtrer'); ?></button>
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
                        <h5><?php echo __('Inventaires'); ?></h5>
                    </div>
                    <div class="ibox-content">
                        <table id="tInv" class="table table-striped table-bordered table-hover dataTables display responsive no-wrap" width="100%" >
                            <thead>
                                <tr>
                                    <th><?php echo __('Emplacement'); ?></th>
                                    <th><?php echo __('Date'); ?></th>
                                    <th><?php echo __('Numéro d’Arrivage'); ?></th>
                                    <th><?php echo __('Numéro de commande '); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                                foreach ($inventaires as $inventaire) { ?>
                                    <tr>
                                        <td><?php echo $inventaire[5] ?></td>
                                        <td><?php echo $inventaire[2] ?></td>
                                        <td><?php echo $inventaire[3] ?></td>
                                        <td><?php echo $inventaire["commande_achat"] ?></td>
                                    </tr>
                            <?php
                                }
                                ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th><?php echo __('Emplacement'); ?></th>
                                    <th><?php echo __('Date'); ?></th>
                                    <th><?php echo __('Numéro d’Arrivage'); ?></th>
                                     <th><?php echo __('Numéro de commande '); ?></th>
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

        //Maj des slots du layout
        $('#lytHrchy').html($('#tpltLstHrchy').html());
        
        
        $.fn.dataTable.moment('DD/MM/YYYY HH:mm:ss');
        var table = $('#tInv').DataTable({
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
          extend: 'excel',title: 'export_mouvement'
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
            icons: {
                time: 'fa fa-clock-o',
                date: 'fa fa-calendar',
                up: 'fa fa-chevron-up',
                down: 'fa fa-chevron-down',
                previous: 'fa fa-chevron-left',
                next: 'fa fa-chevron-right',
                today: 'fa fa-crosshairs',
                clear: 'fa fa-trash',
                close: 'fa fa-remove'
            }
        });
        $("#heureDebut").on("dp.change", function (e) {
            $('#heureFin').data("DateTimePicker").minDate(e.date);
        });
        $("#heureFin").on("dp.change", function (e) {
            $('#heureDebut').data("DateTimePicker").maxDate(e.date);
        });
        var config = {
            disable_search_threshold: 10,
            no_results_text: 'Aucun résultat!',
            allow_single_deselect: false
        };
        $('select').chosen(config);
    });
</script>