<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5><?php echo __('Liste des horaires d\'ouverture'); ?></h5>
                <div class="ibox-tools">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-wrench"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a onclick="ajouterHoraires();" >Ajouter</a></li>
                        <li><a onclick="supprimerHoraires();" >Tout supprimer</a></li>
                    </ul>
                </div>
            </div>
            <div class="ibox-content">
                <div id="list-horaires">
                    <?php include_partial("listHoraires", array("horaires" => $horaires)); ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include_partial("horairesModal"); ?>
<?php include_partial("horairesToutSuppModal"); ?>
<script type="text/javascript">
    var tableHoraire = null;
    $(document).ready(function () {
        $.fn.dataTable.moment('HH:mm:ss');
        tableHoraire = $('.dataTablesHoraires').DataTable({
            order: [[0, 'asc'], [1, 'asc']],
            responsive: true,
             pageLength: 100,
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
        $('.timepicker').datetimepicker({
            format: 'HH:mm:ss',
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
        $("#heureDebutHoraire").on("dp.change", function (e) {
            $('#heureFinHoraire').data("DateTimePicker").minDate(e.date);
        });
        $("#heureFinHoraire").on("dp.change", function (e) {
            $('#heureDebutHoraire').data("DateTimePicker").maxDate(e.date);
        });

    });// fin ready

    $(function () {

        jQuery("#context-menu-one-horaires box menu-1").contextMenu({
            selector: '.context-menu-one-horaires',
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
                    ajouterHoraires();
                }
                if (key == "delete") {
                    suppHoraire(m);
                }

            },
            items: {
                "new": {name: "<?php echo __('Ajouter'); ?>", icon: "add"},
                "delete": {name: "<?php echo __('Supprimer'); ?>", icon: "delete"}
            }
        });
    });

    function ajouterHoraires() {
        debut = "08:00:00";
        fin = "18:00:00";
        $("#heureDebutHoraire").val(debut);
        $("#heureFinHoraire").val(fin);
        $('#heureFinHoraire').data("DateTimePicker").minDate(debut);
        $('#heureDebutHoraire').data("DateTimePicker").maxDate(fin);

        $("#selectDayHoraire").val("");
        $('#selectDayHoraire').trigger("chosen:updated");
        $('#modalHoraires').modal("show");

        $("#selectDayHoraire_chosen .default").css("width", "150px");
    }
    function newHoraires() {
        removeAllSet("#selectDayHoraire");
        removeAllSet("#heureDebutHoraire");
        removeAllSet("#heureFinHoraire");
        jour = $("#selectDayHoraire").val();
        debut = $("#heureDebutHoraire").val();
        fin = $("#heureFinHoraire").val();
        erreur = false;
        if (jour === "" || jour === null) {
            setHasError("#selectDayHoraire");
            erreur = true;
        }
        if (debut === "") {
            setHasError("#heureDebutHoraire");
            erreur = true;
        }
        if (fin === "") {
            setHasError("#heureFinHoraire");
            erreur = true;
        }
        if (!erreur) {
            $.post('<?php echo url_for('parametrage-update-horaire') ?>', {'jour': jour, 'debut': debut, 'fin': fin}, function () {
                $('#modalHoraires').modal("hide");
                reloadListHoraires();
            });
        }
    }
    function suppHoraire(id) {
        $.post('<?php echo url_for('parametrage-remove-horaire') ?>', {'id': id}, function () {
            reloadListHoraires();
        });
    }

    function reloadListHoraires() {
        $.ajax({
            url: '<?php echo url_for(array('sf_route' => 'parametrage-list-horaires-ajax')) ?>'
        }).done(function (data) {
            tableHoraire.destroy();
            $('#list-horaires').empty();
            $('#list-horaires').append(data);
            $.fn.dataTable.moment('HH:mm:ss');
            tableHoraire = $('.dataTablesHoraires').DataTable({
                order: [[0, 'asc'], [1, 'asc']],
                responsive: true,
                pageLength: 25,
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.6/i18n/French.json"
                }
            });
        });
    }

    function supprimerHoraires() {
        $('#modalSuppHoraires').modal("show");
    }
    function deleteHoraires() {
        $.post('<?php echo url_for('parametrage-remove-all-horaire') ?>', function () {
            $('#modalSuppHoraires').modal("hide");
            reloadListHoraires();
        });
    }

</script>