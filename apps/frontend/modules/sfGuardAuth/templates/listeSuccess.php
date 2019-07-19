<?php
//Slot du titre de la page
slot('page_title', sprintf("Gestion des utilisateurs"));
?>

<div id="list-ajax-div">
    <div id="tpltLstHrchy" class="hidden">
        <ol class="breadcrumb">
            <li>
                <a href="#"><?php echo __('Paramétrages'); ?></a>
            </li>
            <li class="active">
                <strong><?php echo __('Utilisateurs'); ?></strong>
            </li>
        </ol>
    </div>
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5><?php echo __('Liste des utilisateurs'); ?></h5>
                        <div class="ibox-tools">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                <i class="fa fa-wrench"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-user">
                                <li><a onclick="showForm('<?php echo url_for('utilisateur-new') ?>');"><?php echo __('Ajouter'); ?></a></li>
                                <li><a href="<?php echo url_for('utilisateur-excel') ?>"><?php echo __('Export excel'); ?></a>
                                <li><a href="<?php echo url_for('utilisateur-word') ?>"><?php echo __('Export word'); ?></a>
                                <li><a href="<?php echo url_for('utilisateur-print'); ?>"><?php echo __('Imprimer'); ?></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="ibox-content">

                        <table class="table table-striped table-bordered table-hover dataTables display responsive no-wrap" width="100%" >
                            <thead>
                                <tr>
                                    <th><?php echo __('Numéro d\'utilisateur'); ?></th>
                                    <th><?php echo __('Identifiant'); ?></th>
                                    <th><?php echo __('Actif'); ?></th>
                                    <th><?php echo __('Bloqué'); ?></th>
                                    <th><?php echo __('Dernière connexion'); ?></th>
                                    <th><?php echo __('Groupe'); ?></th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php $ligne = 0;
                                foreach ($utilisateurs as $utilisateur) {
                                    ?>
                                    <tr id="<?php echo $utilisateur->getId() ?>" onmousedown="setIdClic(event, '<?php echo $utilisateur->getId() ?>');" class="context-menu-one box menu-1">
                                        <td><?php echo $utilisateur->getId() ?></td>
                                        <td><?php echo $utilisateur->getUsername() ?></td>
                                        <td>
                                            <?php if ($utilisateur->getIsActive()) { ?>
                                                <i class="fa fa-check text-navy"></i>
                                            <?php } else { ?>
                                                <i class="fa fa-close text-danger"/></i>
    <?php } ?></td>
                                           <td>
                                            <?php if ($utilisateur->getLoginFailed()>=sfGuardUserTable::LOGIN_FAILED_LIMIT) { ?>
                                                <i class="fa fa-check text-danger"></i>
                                            <?php } else { ?>
                                                <i title="<?php echo $utilisateur->getLoginFailed()?> tentative(s) de connexion echouée(s)" class="fa fa-close text-navy"/></i>
    <?php } ?></td>
                                        <td><?php echo format_date($utilisateur->getLastLogin(), 'U') ?></td>
                                        <td><?php echo $utilisateur->getGroup() ?></td>
                                    </tr>
    <?php $ligne++;
}
?>

                            </tbody>
                            <tfoot>
                                <tr>
                                    <th><?php echo __('Numéro d\'utilisateur'); ?></th>
                                    <th><?php echo __('Identifiant'); ?></th>
                                    <th><?php echo __('Actif'); ?></th>
                                      <th><?php echo __('Bloqué'); ?></th>
                                    <th><?php echo __('Dernière connexion'); ?></th>
                                    <th><?php echo __('Groupe'); ?></th>
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
                <h4 class="modal-title">Supprimer un utilisateur</h4>
            </div>
            <div class="modal-body">
                <p>Voulez-vous vraiment supprimer cet utilisateur ? <br><strong>Cette action est irréversible !</strong></p>
            </div>
            <input type="hidden" id="user-supp-id"/>
            <div class="modal-footer">
                <button type="button" class="btn btn-white" data-dismiss="modal">Annuler</button>
                <button type="button" class="btn btn-primary" onclick="suppUser();" data-dismiss="modal">Supprimer</button>
            </div>
        </div>
    </div>
</div>

<div id="ajax-div"></div>

<script>
    $(document).ready(function () {

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

    $(function () {

        var idCo = <?php echo $sf_user->getGuardUser()->getId(); ?>;
        var selCo = false;

        jQuery("#context-menu-one box menu-1").contextMenu({
            selector: '.context-menu-one',
            events: {
                show: function (opt) {
                    if (m == idCo)
                        selCo = true;
                    else
                        selCo = false;

                    $('#' + m).css('background-color', '#e4e4e4');
                },
                hide: function () {
                    $('#' + m).css('background-color', '');
                }
            },
            callback: function (key, options) {

                if (key == "add") {
                    showForm('<?php echo url_for('utilisateur-new') ?>');
                }
                if (key == "edit") {
                    showForm('<?php echo url_for('@utilisateur-edit') ?>?id=' + m);
                }
                if (key == "delete") {
                    showSuppModal(m);
                }
                if (key == "excel") {
                    window.location.replace("<?php echo url_for('utilisateur-excel') ?>");
                }
                if (key == "word") {
                    window.location.replace("<?php echo url_for('utilisateur-word') ?>");
                }
                if (key == "print") {
                    window.location.replace("<?php echo url_for('utilisateur-print') ?>");
                }
                
                 if (key == "debloquer") {
                    $.post('<?php echo url_for('utilisateur-debloquer') ?>', {'id': m}, function () {
            document.location.href = "<?php echo url_for('@gestion-des-utilisateurs') ?>";
        });
                }

            },
            items: {
                "add": {name: "Ajouter", icon: "add"},
                "edit": {name: "Modifier", icon: "edit"},
                "delete": {name: "Supprimer", icon: "delete"},
                "sep1": "---------------",
                 "debloquer": {name: "Débloquer", icon: "edit"},
                  "sep2": "---------------",
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

    function suppUser() {
        $.post('<?php echo url_for('utilisateur-delete') ?>', {'id': $('#user-supp-id').val()}, function () {
            document.location.href = "<?php echo url_for('@gestion-des-utilisateurs') ?>";
        });
    }

</script>