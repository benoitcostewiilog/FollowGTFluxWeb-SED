<?php
//Slot du titre de la page
slot('page_title', sprintf('Réception'));
?>
<div id="list-ajax-div">
    <div id="tpltLstHrchy" class="hidden">
        <ol class="breadcrumb">
            <li>
                <a href="#"><?php echo __('Historique'); ?></a>
            </li>
            <li class="active">
                <strong><?php echo __('Réception'); ?></strong>
            </li>
        </ol>
    </div>
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5><?php echo __('Filtrer les réceptions :') ?></h5>
                        <div class="ibox-tools">
                            <a class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                            </a>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <form id="formFiltre" action="<?php echo url_for('reception') ?>" class="form-horizontal" method="POST">
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="row">
                                        <div class="row">
                                            <div class="form-group">
                                                <label class="col-lg-4 control-label"><?php echo __('N° reception'); ?></label>
                                                <div class="col-lg-8">
                                                    <input id="filtrebrSap" value="<?php echo $brSap ?>" name="brSap" class="form-control"/>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-7 col-lg-offset-5">
                                            <div class="form-group">
                                                <button class="btn btn-primary" type="submit"><?php echo __('Filtrer'); ?></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="row">
                                        <div class="form-group">
                                            <label class="col-lg-4 control-label"><?php echo __('N° arrivage'); ?></label>
                                            <div class="col-lg-8">
                                                <input id="filtreProduit" value="<?php echo $produit ?>" name="produit" class="form-control"/>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="row">
                                        <div class="form-group">
                                            <label class="col-lg-4 control-label"><?php echo __('Début'); ?></label>
                                            <div class="col-lg-8">
                                                <input id="filtreHeureDebut" value="<?php echo $heureDebut ?>" name="heureDebut" class="form-control dateFiltre"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group">
                                            <label class="col-lg-4 control-label"><?php echo __('Fin'); ?></label>
                                            <div class="col-lg-8">
                                                <input id="filtreHeureFin" value="<?php echo $heureFin ?>" name="heureFin" class="form-control dateFiltre"/>
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
        <div class="row rowTable">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5><?php echo __('Liste des réceptions'); ?></h5>
                        <div class="ibox-tools">
                            <?php if ($sf_user->hasCredential('reception-ecriture')) { ?>
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                <i class="fa fa-wrench"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-user">
                                <li><a onclick="exporter('excel');" >Export Excel</a></li>
                                <li><a onclick="exporter('word');" >Export Word</a></li>
                                <li><a onclick="exporter('print');" >Imprimer</a></li>
                            </ul>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <?php include_partial('list', array('assBR' => $assBR, 'users' => $users)) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal inmodal fade" id="suppReception" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only"><?php echo __('Fermer'); ?></span></button>
                <h4 class="modal-title"><?php echo __('Supprimer une réception'); ?></h4>
            </div>
            <div class="modal-body">
                <p id="deleteMessage"><?php echo __('Voulez-vous vraiment supprimer cette réception ? '); ?><span id="objectName"></span><br><strong><?php echo __('Cette action est irréversible !'); ?></strong></p>
            </div>
            <div class="modal-footer">
                <button id="cancelButton" type="button" class="btn btn-white" data-dismiss="modal"><?php echo __('Annuler'); ?></button>
                <button id="deleteButton" type="button" class="btn btn-danger" onclick="doSuppReception();" ><?php echo __('Supprimer'); ?></button>
            </div>
        </div>
    </div>
</div>
<script>
    var table = null;
    $(document).ready(function () {
        //Maj des slots du layout
        $('#lytHrchy').html($('#tpltLstHrchy').html());
        $.fn.dataTable.moment('DD/MM/YYYY HH:mm:ss');
        table = $('.dataTables').DataTable({
            order: [[2, 'desc']],
            responsive: true,
            colReorder: true,
            stateSave: true,
             pageLength: 100,
            buttons: [
                <?php if ($sf_user->hasCredential('reception-ecriture')) { ?>
                'copy',
                {extend: 'print',
                    customize: function (win) {
                        $(win.document.body).addClass('white-bg');
                        $(win.document.body).css('font-size', '10px');
                        $(win.document.body).find('table').addClass('compact').css('font-size', 'inherit');
                    }
                }, {extend: 'excel', title: 'export_reception'}, {extend: 'csv', title: 'export_reception'}, {extend: 'pdf', title: 'export_reception'}, 'colvis'
                <?php } ?>],
            pageLength: 100,
            "language": {
                "sProcessing": "Traitement en cours...",
                "sSearch": "Rechercher&nbsp;:",
                "sLengthMenu": "Afficher _MENU_ &eacute;l&eacute;ments",
                "sInfo": "Affichage de l'&eacute;l&eacute;ment _START_ &agrave; _END_ sur _TOTAL_ &eacute;l&eacute;ments",
                "sInfoEmpty": "Affichage de l'&eacute;l&eacute;ment 0 &agrave; 0 sur 0 &eacute;l&eacute;ment",
                "sInfoFiltered": "(filtr&eacute; de _MAX_ &eacute;l&eacute;ments au total)",
                "sInfoPostFix": "",
                "sLoadingRecords": "Chargement en cours...",
                "sZeroRecords": "Aucun &eacute;l&eacute;ment &agrave; afficher",
                "sEmptyTable": "Aucune donn&eacute;e disponible dans le tableau",
                "oPaginate": {
                    "sFirst": "Premier",
                    "sPrevious": "Pr&eacute;c&eacute;dent",
                    "sNext": "Suivant",
                    "sLast": "Dernier"
                },
                "oAria": {
                    "sSortAscending": ": activer pour trier la colonne par ordre croissant",
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
        setTimeout(function () {
            table.buttons().container().appendTo('#DataTables_Table_0_wrapper .col-sm-6:eq(0)');
            $('#DataTables_Table_0_wrapper .col-sm-6:eq(0)').attr('class', 'col-sm-8');
            $('#DataTables_Table_0_wrapper .col-sm-6:eq(0)').attr('class', 'col-sm-4');
            $('#DataTables_Table_0_length').css('margin-right', '25px');

        }, 500);
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
        $("#filtreHeureDebut").on("dp.change", function (e) {
            $('#filtreHeureFin').data("DateTimePicker").minDate(e.date);
        });
        $("#filtreHeureFin").on("dp.change", function (e) {
            $('#filtreHeureDebut').data("DateTimePicker").maxDate(e.date);
        });

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
                    if (key == "delete") {
                        showSuppReceptionModal();
                    }

                },
                items: {
<?php if ($sf_user->hasCredential('reception-ecriture')) { ?>
                    "delete": {name: "<?php echo __('Supprimer'); ?>", icon: "delete"}
<?php } ?>
                }
    });
    });
            function showSuppReceptionModal() {
                $('#deleteMessage').html("<?php echo __('Voulez-vous vraiment supprimer cet réception ? '); ?>");
                $('#cancelButton').html("<?php echo __('Annuler'); ?>");
                $('#deleteButton').show();
                $('#suppReception').modal('show');
            }
    function doSuppReception() {
        $.ajax({
            url: '<?php echo url_for('reception-delete') ?>',
            type: 'post',
            data: {'id': m},
            success: function (data) {
                if (data === '1') {
                    table.row('#' + m).remove().draw();
                    $('#loader').css('visibility', 'hidden');
                    $('#suppReception').modal('hide');
                } else {
                    $('#deleteMessage').html("<?php echo __('Une erreur est survenue lors de la suppression!'); ?>");
                    $('#cancelButton').html("<?php echo __('OK'); ?>");
                    $('#deleteButton').hide();
                }
            }
        });
    }
    function reloadList() {
        $.ajax({
            url: '<?php echo url_for(array('sf_route' => 'reception-list-ajax')) ?>'
        }).done(function (data) {
            table.destroy();
            $('#list-ajax-div .rowTable .ibox-content').empty();
            $('#list-ajax-div .rowTable .ibox-content').append(data);
            table = $('#list-ajax-div .rowTable .ibox-content .dataTables').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.6/i18n/French.json"
                }
            });
        });
    }
    function exporter(type) {
        url = '';
        switch (type) {
            case 'excel':
                url = '<?php echo url_for(array('sf_route' => 'reception-excel')) ?>';
                break;
            case 'word':
                url = '<?php echo url_for(array('sf_route' => 'reception-word')) ?>';
                break;
            case 'print':
                url = '<?php echo url_for(array('sf_route' => 'reception-print')) ?>';
                break;
        }
        debut = $('#filtreHeureDebut').val();
        fin = $('#filtreHeureFin').val();
        produit = $('#filtreProduit').val();
        brSap = $('#filtrebrSap').val();
        url = url + '?heureDebut=' + debut + '&heureFin=' + fin + '&produit=' + produit + '&brSap=' + brSap;
        location.assign(url);
    }
</script>