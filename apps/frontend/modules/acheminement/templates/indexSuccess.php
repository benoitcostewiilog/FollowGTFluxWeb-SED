<?php
//Slot du titre de la page
slot('page_title', sprintf('Gestion des demandes d\'acheminements'));
?>

<div id="list-ajax-div">
    <div id="tpltLstHrchy" class="hidden">
        <ol class="breadcrumb">
            <li>
                <a href="#"><?php echo __('Acheminement'); ?></a>
            </li>
            <li class="active">
                <strong><?php echo __('Liste'); ?></strong>
            </li>
        </ol>
    </div>
    <div class="wrapper wrapper-content">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5><?php echo __('Demandes d\'acheminement'); ?></h5>
                        <div class="ibox-tools">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                <i class="fa fa-wrench"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-user">
                                <li><a onclick="showForm('<?php echo url_for(array('sf_route' => 'acheminement-new')) ?>');"><?php echo __('Ajouter') ?></a>
                            </ul>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <?php include_partial('list', array('acheminements' => $acheminements)) ?> 
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal inmodal fade" id="suppAcheminement" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only"><?php echo __('Fermer'); ?></span></button>
                <h4 class="modal-title"><?php echo __('Supprimer un acheminement'); ?></h4>
            </div>
            <div class="modal-body">
                <p id="deleteMessage"><?php echo __('Voulez-vous vraiment supprimer cet acheminement ? '); ?><span id="objectName"></span><br><strong><?php echo __('Cette action est irréversible !'); ?></strong></p>
            </div>
            <div class="modal-footer">
                <button id="cancelButton" type="button" class="btn btn-white" data-dismiss="modal"><?php echo __('Annuler'); ?></button>
                <button id="deleteButton" type="button" class="btn btn-danger" onclick="doSuppAcheminement();" ><?php echo __('Supprimer'); ?></button>
            </div>
        </div>
    </div>
</div>
<div id="ajax-div"></div>

<script>
    $(document).ready(function () {

        $('#lytHrchy').html($('#tpltLstHrchy').html());
        
        $.fn.dataTable.moment('DD/MM/YYYY HH:mm:ss');
        table = $('#Tacheminement').DataTable({
        colReorder: true,
        pageLength: 100,
        stateSave: true,
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
            {
                text: 'Créer acheminement',
                action: function (e, dt, node, config ) {
                  showForm('<?php echo url_for(array('sf_route' => 'acheminement-new')) ?>');
                }
            },
                  <?php if (!$sf_user->hasCredential('acheminement-sans-export')) { ?>
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
             <?php } ?>
            'colvis'
          ]
        });

        var btns = table.buttons();
        var btncontainer = table.buttons().container();
        btncontainer.appendTo('#buttons');
        $('#buttons').addClass('col-md-6');
        $('#buttons').css({'padding': '0', 'margin-bottom': '6px'});
        $('#buttons').siblings().eq(0).css({'padding': '0', 'margin-bottom': '6px'});
        
        
        
        $("#ajax-div").hide();
        
        
    });
    $(function () {

        jQuery("#context-menu-one box menu-1").contextMenu({
            selector: '.context-menu-one',
            events: {
                show: function (opt) {
                    $('#' + m).css('background-color', '#e4e4e4');
                },
                hide: function () {
                    $('#' + m).css('background-color', '');
                }
            },
            callback: function (key, options) {

                if (key == "add") {
                    showForm('<?php echo url_for(array('sf_route' => 'acheminement-new')) ?>');
                }
                if (key == "edit") {
                    showForm('<?php echo url_for('acheminement-edit') ?>?id=' + m);
                }
                if (key == "delete") {
                    showSuppAcheminementModal();
                }
                if (key == "print") {
                    location.assign('<?php echo url_for(array('sf_route' => 'acheminement-print')) ?>?id=' + m);
                }
                if (key == "pdf") {
                    location.assign('<?php echo url_for(array('sf_route' => 'acheminement-pdf')) ?>?id=' + m);
                }
            },
            items: {
                "add": {name: "<?php echo __('Ajouter'); ?>", icon: "add"}
         <?php if (!$sf_user->hasCredential('acheminement-sans-export')) { ?>
             ,
                "edit": {name: "<?php echo __('Modifier'); ?>", icon: "edit"},
                "delete": {name: "<?php echo __('Supprimer'); ?>", icon: "delete"},
                "sep1": "---------------",
                "print": {name: "<?php echo __('Imprimer Tracking'); ?>", icon: "print"},
                "pdf": {name: "<?php echo __('Télécharger Tracking'); ?>", icon: "download"}
         <?php } ?>
            }
        });
    });
    function showSuppAcheminementModal() {
        $('#deleteMessage').html("<?php echo __('Voulez-vous vraiment supprimer cet acheminement ? '); ?>");
        $('#cancelButton').html("<?php echo __('Annuler'); ?>");
        $('#deleteButton').show();
        $('#suppAcheminement').modal('show');
    }

    function doSuppAcheminement() {
        $.ajax({
            url: '<?php echo url_for('acheminement-delete') ?>',
            type: 'post',
            data: {'id': m},
            success: function (data) {
                if (data === '1') {
                    table.row('#' + m).remove().draw();
                    $('#loader').css('visibility', 'hidden');
                    $('#suppAcheminement').modal('hide');
                } else {
                    $('#deleteMessage').html("<?php echo __('Une erreur est survenue lors de la suppression!'); ?>");
                    $('#cancelButton').html("<?php echo __('OK'); ?>");
                    $('#deleteButton').hide();
                    $('#suppAcheminement').modal('show');
                }
            }
        });
    }
    function reloadList() {
        $.ajax({
            url: '<?php echo url_for(array('sf_route' => 'acheminement-list-ajax')) ?>'
        }).done(function (data) {
            table.destroy();
            $('#list-ajax-div .ibox-content').empty();
            $('#list-ajax-div .ibox-content').append(data);
            table = $('#list-ajax-div .ibox-content .dataTables').DataTable({
                order: [[3, 'desc']],
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.6/i18n/French.json"
                }
            });
        });
    }
        
    function reloadList() {
        $.ajax({
            url: '<?php echo url_for(array('sf_route' => 'acheminement-list-ajax')) ?>'
        }).done(function (data) {
            table.destroy();
            $('#list-ajax-div .ibox-content').empty();
            $('#list-ajax-div .ibox-content').append(data);
            table = $('#list-ajax-div .ibox-content .dataTables').DataTable({
                order: [[3, 'desc']],
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.6/i18n/French.json"
                }
            });
        });
    }
</script>