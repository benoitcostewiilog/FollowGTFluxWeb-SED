<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5><?php echo __('Liste des jours fériés'); ?></h5>
                <div class="ibox-tools">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-wrench"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a onclick="ajouterFerie();" >Ajouter</a></li>
                    </ul>
                </div>
            </div>
            <div class="ibox-content">
                <div id="list-feries">
                    <?php include_partial("listFeries", array("feries" => $feries)); ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include_partial("feriesModal"); ?>
<script type="text/javascript">
    var tableFeries = null;
    $(document).ready(function () {
        $.fn.dataTable.moment('DD/MM/YYYY');
        tableFeries = $('.dataTablesFeries').DataTable({
            order: [[1, 'asc']],
             pageLength: 100,
            responsive: true,
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.6/i18n/French.json"
            }
        });

        var config = {
            disable_search_threshold: 10, //on cache le champs de recherche si il y a moins de 10 elements
            no_results_text: 'Aucun résultat!',
            allow_single_deselect: false,
            width: "100%"
        };
        $('select').chosen(config);
        $('.datetimepicker').datetimepicker({
            format: 'DD/MM/YYYY',
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

        $('#jourRadio').change(function () {
            $('#selectAnnee').attr('disabled', 'disabled');
            $('#jourTable').find('input').removeAttr('disabled');

            $('#selectAnnee').trigger("chosen:updated");
        });
        $('#ferieRadio').change(function () {
            $('#selectAnnee').removeAttr('disabled');
            $('#jourTable').find('input').attr('disabled', 'disabled');

            $('#selectAnnee').trigger("chosen:updated");
           
        });
    });// fin ready

    $(function () {

        jQuery("#context-menu-one-feries box menu-1").contextMenu({
            selector: '.context-menu-one-feries',
            events: {
                show: function (opt) {
                    $('#' + m).css('background-color', '#e4e4e4');
                },
                hide: function () {
                    $('#' + m).css('background-color', '');
                }
            },
            callback: function (key, options) {
                if (key == "new") {
                    ajouterFerie();
                }
                if (key == "delete") {
                    suppFerie(m);
                }

            },
            items: {
                "new": {name: "<?php echo __('Ajouter'); ?>", icon: "add"},
                "delete": {name: "<?php echo __('Supprimer'); ?>", icon: "delete"}
            }
        });
    });

    //FERIES
    function ajouterFerie() {
        $("#modalFeries").modal('show');
        $('#libFerie').val('');
        $('#datepicker').val('');
    }

    function enregistrerFeries() {
        if ($('#ferieRadio').is(':checked')) {
            addDateFerie();
            $("#modalFeries").modal('hide');
        } else {
            if (controleSaisieFeries()) {
                addJour();
                $("#modalFeries").modal('hide');
            }
        }
    }

    function controleSaisieFeries() {
        var retour = true;

        if ($('#libFerie').val() == "") {
            animError('#libFerie', 2);
            retour = false;
        }
        if ($('#datepicker').val() == "") {
            animError('#datepicker', 2);
            retour = false;
        }

        return retour;
    }

    function addJour() {
        var lib = $('#libFerie').val();
        var date = $('#dateJourFerie').val();
        $.post('<?php echo url_for('parametrage-add-jour') ?>', {'libelle': lib, 'date': date}, function () {
            reloadListFeries();
        });
    }

    function addDateFerie() {
        var annee = $('#selectAnnee').val();
        $.post('<?php echo url_for('parametrage-add-feries') ?>', {'annee': annee}, function (data) {
            reloadListFeries();
        });
    }

    function suppFerie(id) {
        $.post('<?php echo url_for('parametrage-remove-jour-feries') ?>', {'id': id}, function () {
            reloadListFeries();
        });
    }

    function reloadListFeries() {
        $.ajax({
            url: '<?php echo url_for(array('sf_route' => 'parametrage-list-feries-ajax')) ?>'
        }).done(function (data) {
            tableFeries.destroy();
            $('#list-feries').empty();
            $('#list-feries').append(data);
            $.fn.dataTable.moment('DD/MM/YYYY');
            tableFeries = $('.dataTablesFeries').DataTable({
                order: [[1, 'asc']],
                responsive: true,
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.6/i18n/French.json"
                }
            });
        });
    }

</script>