<?php
//Slot du titre de la page
slot('page_title', sprintf("Gestion des groupes"));
?>

<div id="list-ajax-div">
    <div id="tpltLstHrchy" class="hidden">
        <ol class="breadcrumb">
            <li>
                <a href="#"><?php echo __('Paramétrages'); ?></a>
            </li>
            <li class="active">
                <strong><?php echo __('Groupes'); ?></strong>
            </li>
        </ol>
    </div>
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5><?php echo __('Liste des groupes'); ?></h5>
                        <div class="ibox-tools">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                <i class="fa fa-wrench"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-user">
                                <li><a onclick="showForm('<?php echo url_for('groupe-new') ?>');"><?php echo __('Ajouter'); ?></a></li>
                                <li><a href="<?php echo url_for('groupe-excel') ?>"><?php echo __('Export excel'); ?></a></li>
                                <li><a href="<?php echo url_for('groupe-word') ?>"><?php echo __('Export work'); ?></a></li>
                                <li><a href="<?php echo url_for('groupe-print'); ?>"><?php echo __('Imprimer'); ?></a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="ibox-content">

                        <table class="table table-striped table-bordered table-hover dataTables display responsive no-wrap" width="100%" >
                            <thead>
                                <tr>
                                    <th><?php echo __('Numéro de groupe'); ?></th>
                                    <th><?php echo __('Nom'); ?></th>
                                    <th><?php echo __('Description'); ?></th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php $ligne = 0;
                                foreach ($groupes as $groupe) {
                                    ?>
                                    <tr id="<?php echo $groupe->getId() ?>" onmousedown="setIdClic(event, '<?php echo $groupe->getId() ?>');" class="context-menu-one box menu-1">
                                        <td><?php echo $groupe->getId() ?></td>
                                        <td><?php echo $groupe->getName() ?></td>
                                        <td><?php echo $groupe->getDescription() ?></td>
                                    </tr>
<?php } ?>

                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Numéro de groupe</th>
                                    <th>Nom</th>
                                    <th>Description</th>
                                </tr>
                            </tfoot>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal inmodal fade" id="myModal6" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Supprimer un groupe</h4>
            </div>
            <div class="modal-body">
                <p>Voulez-vous vraiment supprimer ce groupe ? <br><strong>Cette action est irréversible !</strong></p>
            </div>
            <input type="hidden" id="user-supp-id"/>
            <div class="modal-footer">
                <button type="button" class="btn btn-white" data-dismiss="modal">Annuler</button>
                <button type="button" class="btn btn-primary" onclick="supGroup();" data-dismiss="modal">Supprimer</button>
            </div>
        </div>
    </div>
</div>

<div id="ajax-div"></div>

<script language="javascript">
    $(document).ready(function () {
        //Maj des slots du layout
        $('#lytHrchy').html($('#tpltLstHrchy').html());

        $('.dataTables').dataTable({
            responsive: true,
             pageLength: 100,
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.6/i18n/French.json"
            }
        });

        $("#ajax-div").hide();
    });

    var m;

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
                    showForm('<?php echo url_for('groupe-new') ?>');
                }
                if (key == "edit") {
                    showForm('<?php echo url_for('groupe-edit') ?>?id=' + m);
                }
                if (key == "delete") {
                    showSuppModal(m);
                }
                if (key == "excel") {
                    window.location.replace("<?php echo url_for('groupe-excel') ?>");
                }
                if (key == "word") {
                    window.location.replace("<?php echo url_for('groupe-word') ?>");
                }
                if (key == "print") {
                    window.location.replace("<?php echo url_for('groupe-print') ?>");
                }

            },
            items: {
                "add": {name: "Ajouter", icon: "add"},
                "edit": {name: "Modifier", icon: "edit"},
                "delete": {name: "Supprimer", icon: "delete"},
                "sep1": "---------------",
                "export": {
                    "name": "Exporter", icon: "export",
                    "items": {
                        "excel": {name: "Excel", icon: "excel"},
                        "word": {name: "Word", icon: "word"}
                    }
                },
                "print": {name: "Imprimer", icon: "print"}
            }
        });

    });



    function showSuppModal(m) {
        $('#myModal6').modal('show');
        $('#user-supp-id').val(m);
    }

    function supGroup() {
        $.post('<?php echo url_for('groupe-delete') ?>', {'id': $('#user-supp-id').val()}, function () {
            document.location.href = "<?php echo url_for('@gestion-des-groupes') ?>";
        });
    }
</script>