<?php
//Slot du titre de la page
slot('page_title', sprintf('Destinataire acheminements'));
?>

<div id="list-ajax-div">
    <div id="tpltLstHrchy" class="hidden">
        <ol class="breadcrumb">
            <li>
                <a href="#"><?php echo __('Paramétrage'); ?></a>
            </li>
            <li class="active">
                <strong><?php echo __('Destinataire'); ?></strong>
            </li>
        </ol>
    </div>
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5><?php echo __('Destinataire'); ?></h5>
                        <div class="ibox-tools">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                <i class="fa fa-wrench"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-user">
                                <li><a onclick="showForm('<?php echo url_for(array('sf_route' => 'destinataire-acheminement-new')) ?>');"><?php echo __('Ajouter') ?></a>
                            </ul>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <?php include_partial('list', array('destinataires' => $destinataires)) ?> </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal inmodal fade" id="suppDestinataire" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only"><?php echo __('Fermer'); ?></span></button>
                <h4 class="modal-title"><?php echo __('Supprimer un destinataire'); ?></h4>
            </div>
            <div class="modal-body">
                <p id="deleteMessage"><?php echo __('Voulez-vous vraiment supprimer ce destinataire ? '); ?><span id="objectName"></span><br><strong><?php echo __('Cette action est irréversible !'); ?></strong></p>
            </div>
            <div class="modal-footer">
                <button id="cancelButton" type="button" class="btn btn-white" data-dismiss="modal"><?php echo __('Annuler'); ?></button>
                <button id="deleteButton" type="button" class="btn btn-danger" onclick="doSuppDestinataire();" ><?php echo __('Supprimer'); ?></button>
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

        table = $('.dataTables').DataTable({
            pageLength: 100,
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.6/i18n/French.json"
            }
        });
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
                    showForm('<?php echo url_for(array('sf_route' => 'destinataire-acheminement-new')) ?>');
                }
                if (key == "edit") {
                    showForm('<?php echo url_for('destinataire-acheminement-edit') ?>?id=' + m);
                }
                if (key == "delete") {
                    showSuppEmplacementModal();
                }

            },
            items: {
                "add": {name: "<?php echo __('Ajouter'); ?>", icon: "add"},
                "edit": {name: "<?php echo __('Modifier'); ?>", icon: "edit"},
                "delete": {name: "<?php echo __('Supprimer'); ?>", icon: "delete"}
            }
        });
    });
    function showSuppEmplacementModal() {
        $('#deleteMessage').html("<?php echo __('Voulez-vous vraiment supprimer ce destinataire ? '); ?>");
        $('#cancelButton').html("<?php echo __('Annuler'); ?>");
        $('#deleteButton').show();
        $('#suppDestinataire').modal('show');
    }

    function doSuppDestinataire() {
        $.ajax({
            url: '<?php echo url_for('destinataire-acheminement-delete') ?>',
            type: 'post',
            data: {'id': m},
            success: function (data) {
                if (data === '1') {
                    table.row('#' + m).remove().draw();
                    $('#loader').css('visibility', 'hidden');
                    $('#suppDestinataire').modal('hide');
                } else {
                    $('#deleteMessage').html("<?php echo __('Une erreur est survenue lors de la suppression!'); ?>");
                    $('#cancelButton').html("<?php echo __('OK'); ?>");
                    $('#deleteButton').hide();
                    $('#suppDestinataire').modal('show');
                }
            }
        });
    }
    function reloadList() {
        $.ajax({
            url: '<?php echo url_for(array('sf_route' => 'destinataire-acheminement-list-ajax')) ?>'
        }).done(function (data) {
            table.destroy();
            $('#list-ajax-div .ibox-content').empty();
            $('#list-ajax-div .ibox-content').append(data);
            table = $('#list-ajax-div .ibox-content .dataTables').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.6/i18n/French.json"
                }
            });
        });
    }

</script>