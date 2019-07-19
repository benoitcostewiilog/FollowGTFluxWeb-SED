<?php
//Slot du titre de la page
slot('page_title', sprintf("Historique des expeditions"));
?>

<div id="list-ajax-div">
    <div id="tpltLstHrchy" class="hidden">
        <ol class="breadcrumb">
            <li>
                <a href="#"><?php echo __('Historique'); ?></a>
            </li>
            <li class="active">
                <strong><?php echo __('Expeditions'); ?></strong>
            </li>
        </ol>
    </div>
    <div class="wrapper wrapper-content">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5><?php echo __('Filtrer les expeditions :') ?></h5>
                        <div class="ibox-tools">
                            <a class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                            </a>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <form id="formFiltre" action="<?php echo url_for('expedition') ?>" class="form-horizontal" method="POST">
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="row">
                                        <div class="form-group">
                                            <label class="col-lg-4 control-label"><?php echo __('N° d\'expédition'); ?></label>
                                            <div class="col-lg-8">
                                                <input id="filtreProduit" value="<?php echo $produit ?>" name="produit" class="form-control"/>
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
                                <div class="col-lg-4">
                                    <div class="row">
                                        <div class="form-group">
                                            <label class="col-lg-4 control-label"><?php echo __('Transporteur'); ?></label>
                                            <div class="col-lg-8">
                                                <select id="filtreTransporteur" name="transporteur" class="form-control" data-placeholder=" ">
                                                    <option value="">Aucun</option>
                                                    <?php foreach ($transporteurs as $value) { ?>
                                                        <option <?php echo ($value->getIdTransporteur() == $transporteur ? 'selected' : '') ?> value="<?php echo $value->getIdTransporteur() ?>"><?php echo $value->getLibelle() ?></option>
                                                    <?php } ?>
                                                </select>
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
                        <h5><?php echo __('Historique des expeditions de marchandises'); ?></h5>
                        <div class="ibox-tools">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                <i class="fa fa-wrench"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-user">
                                <?php if ($sf_user->hasCredential('expedition-ecriture')) { ?>
                                    <li><a onclick="showForm('<?php echo url_for('expedition-new') ?>')">Ajouter</a></li>
                                <?php } ?>
                                <li><a onclick="exporter('excel');" >Export Excel</a></li>
                                <li><a onclick="exporter('word');" >Export Word</a></li>
                                <li><a onclick="exporter('print');" >Imprimer</a></li>    </ul>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <?php include_partial('list', array('expeditions' => $expeditions)) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal inmodal fade" id="suppExpedition" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only"><?php echo __('Fermer'); ?></span></button>
                <h4 class="modal-title"><?php echo __('Supprimer une expédition'); ?></h4>
            </div>
            <div class="modal-body">
                <p id="deleteMessage"><?php echo __('Voulez-vous vraiment supprimer cette expédition ? '); ?><span id="objectName"></span><br><strong><?php echo __('Cette action est irréversible !'); ?></strong></p>
            </div>
            <div class="modal-footer">
                <button id="cancelButton" type="button" class="btn btn-white" data-dismiss="modal"><?php echo __('Annuler'); ?></button>
                <button id="deleteButton" type="button" class="btn btn-danger" onclick="doSuppExpedition();" ><?php echo __('Supprimer'); ?></button>
            </div>
        </div>
    </div>
</div>
<div id="ajax-div"></div>
<script>
    var table = null;
    $(document).ready(function () {

        //Maj des slots du layout
        $('#lytHrchy').html($('#tpltLstHrchy').html());

        $.fn.dataTable.moment('DD/MM/YYYY HH:mm:ss');
        table = $('.dataTables').DataTable({
            order: [[5, 'desc']],
            pageLength: 100,
            responsive: true,
            colReorder: true,
            stateSave: true,
            buttons: [
                {
                    text: 'Ajouter',
                    action: function (e, dt, node, config) {
                          showForm('<?php echo url_for('expedition-new') ?>');
                    }
                }, 'copy',
                {extend: 'print',
                    customize: function (win) {
                        $(win.document.body).addClass('white-bg');
                        $(win.document.body).css('font-size', '10px');
                        $(win.document.body).find('table').addClass('compact').css('font-size', 'inherit');
                    }
                }, {extend: 'excel', title: 'export_expedition'}, {extend: 'csv', title: 'export_expedition'}, {extend: 'pdf', title: 'export_expedition'}, 'colvis'],
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

        $('.image-popup-no-margins').magnificPopup({type: 'image', closeOnContentClick: true, closeBtnInside: true, fixedContentPos: true, mainClass: 'mfp-no-margins mfp-with-zoom', image: {verticalFit: true}, zoom: {enabled: true, duration: 300}});

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
        var config = {
            disable_search_threshold: 10, //on cache le champs de recherche si il y a moins de 10 elements
            no_results_text: 'Aucun résultat!',
            allow_single_deselect: false
        };
        $('select').chosen(config);
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
                    if (key == "edit") {
                        edit(m);
                    }
                    if (key == "add") {
                        showForm('<?php echo url_for('expedition-new') ?>');
                    }
                    if (key == "showItem") {
                        showProduits(m);
                    }
                    if (key == "delete") {
                        showSuppExpeditionModal();
                    }

                },
                items: {
                "showItem": {name: "<b><?php echo __('Voir expedition'); ?></b>", icon: "bord"},
<?php if ($sf_user->hasCredential('expedition-ecriture')) { ?>
                    "sep1": "---------------",
                            "add": {name: "<?php echo __('Ajouter'); ?>", icon: "add"},
                            "edit": {name: "<?php echo __('Modifier'); ?>", icon: "edit"},
                            "delete"
                    : {name: "<?php echo __('Supprimer'); ?>", icon: "delete"}
<?php } ?>
                }
    });
    });
            function edit(m) {
                showForm('<?php echo url_for('expedition-edit') ?>?idExpedition=' + m);
            }
    function showSuppExpeditionModal() {
        $('#deleteMessage').html("<?php echo __('Voulez-vous vraiment supprimer cette expédition ? '); ?>");
        $('#cancelButton').html("<?php echo __('Annuler'); ?>");
        $('#deleteButton').show();
        $('#suppExpedition').modal('show');
    }
    function doSuppExpedition() {
        $.ajax({
            url: '<?php echo url_for('expedition-delete') ?>',
            type: 'post',
            data: {'idExpedition': m},
            success: function (data) {
                if (data === '1') {
                    table.row('#' + m).remove().draw();
                    $('#loader').css('visibility', 'hidden');
                    $('#suppExpedition').modal('hide');
                } else {
                    $('#deleteMessage').html("<?php echo __('Une erreur est survenue lors de la suppression!'); ?>");
                    $('#cancelButton').html("<?php echo __('OK'); ?>");
                    $('#deleteButton').hide();
                }
            }
        });
    }

    function reloadList() {
        debut = $('#filtreHeureDebut').val();
        fin = $('#filtreHeureFin').val();
        transporteur = $('#filtreTransporteur').val();
        produit = $('#filtreProduit').val();

        $.ajax({
            url: '<?php echo url_for(array('sf_route' => 'expedition-list-ajax')) ?>',
            data: {heureDebut: debut, heureFin: fin, transporteur: transporteur, produit: produit}
        }).done(function (data) {
            table.destroy();
            $('.modalProduit').remove();
            $('#list-ajax-div .rowTable .ibox-content').empty();
            $('#list-ajax-div .rowTable .ibox-content').append(data);
            table = $('#list-ajax-div .rowTable .ibox-content .dataTables').DataTable({
                order: [[5, 'desc']],
                responsive: true,
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
                url = '<?php echo url_for(array('sf_route' => 'expedition-excel')) ?>';
                break;
            case 'word':
                url = '<?php echo url_for(array('sf_route' => 'expedition-word')) ?>';
                break;
            case 'print':
                url = '<?php echo url_for(array('sf_route' => 'expedition-print')) ?>';
                break;
        }
        debut = $('#filtreHeureDebut').val();
        fin = $('#filtreHeureFin').val();

        transporteur = $('#filtreTransporteur').val();
        produit = $('#filtreProduit').val();

        url = url + '?heureDebut=' + debut + '&heureFin=' + fin + '&transporteur=' + transporteur + '&produit=' + produit /*+ '&statut=' + statut*/;
        location.assign(url);
    }

    function showProduits(idExpedition) {
        $('#produits-' + idExpedition).modal('show');
    }
</script>