<div class="wrapper wrapper-content animated fadeInRight">
    <div id="tpltNvuHrchy" class="hidden">
        <ol class="breadcrumb">
            <li>
                <a href="#"><?php echo __('Paramétrages'); ?></a>
            </li>
            <li>
                <a onclick="goBack();"><?php echo __('Groupes'); ?></a>
            </li>
            <li class="active">
                <strong><?php echo __('Ajouter un groupe'); ?></strong>
            </li>
        </ol>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5><?php echo __('Formulaire d\'ajout d\'un groupe'); ?></small></h5>
                </div>
                <div class="ibox-content">
                    <form action="<?php echo url_for('@groupe-create') ?>" id="formNouveauG" class="form-horizontal" method="POST">
                        <?php echo $form['_csrf_token']; ?>

                        <div class="form-group"><label class="col-sm-2 control-label"><?php echo __('Nom du groupe'); ?></label>
                            <div class="col-sm-10"><?php echo $form['name']->render(array('class' => 'form-control')); ?></div>
                        </div>
                        <div class="hr-line-dashed"></div>

                        <div class="form-group"><label class="col-sm-2 control-label"><?php echo __('Description'); ?></label>
                            <div class="col-sm-10"><?php echo $form['description']->render(array('class' => 'form-control')); ?></div>
                        </div>
                        <div class="hr-line-dashed"></div>

                        <div class="form-group"><label class="col-sm-2 control-label"><?php echo __('Permissions'); ?></label>
                            <div class="col-sm-10"><?php echo $form['permissions_list']->render(array('class' => 'form-control')); ?></div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group"><label class="col-sm-2 control-label">Widgets</label>
                            <div class="col-sm-10"><?php echo $form['widget_list']->render(array('class' => 'form-control')); ?></div>
                        </div>
                        <div class="hr-line-dashed"></div>

                        <div class="form-group">
                            <div class="col-sm-4 col-sm-offset-2">
                                <button class="btn btn-white" onclick="goBack();" type="button"><?php echo __('Annuler'); ?></button>
                                <button class="btn btn-primary" onclick="controlCreerGroupe();" type="button"><?php echo __('Enregistrer'); ?></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    var erreurGroupe = false;
    var erreurDescription = false;

    $(document).ready(function () {

        //Maj des slots du layout
        $('#lytHrchy').html($('#tpltNvuHrchy').html());

        $('#sf_guard_group_name').keypress(function (e) {
            if (e.which == 13)
                return false;
        });

        $("#sf_guard_group_name").focusout(function () {
            if ($("#sf_guard_group_name").val() != "") {
                if (controlNomGroupe($('#sf_guard_group_name').val())) {
                    erreurGroupe = false;
                    setHasSuccess("#sf_guard_group_name");
                }
            } else {
                setHasError("#sf_guard_group_name");
                erreurGroupe = true;
            }
        });

        $("#sf_guard_group_description").focusout(function () {
            if ($("#sf_guard_group_description").val() != "") {
                setHasSuccess("#sf_guard_group_description");
                erreurDescription = false;
            } else {
                setHasError("#sf_guard_group_description");
                erreurDescription = true;
            }
        });
    });// fin ready

    function controlNomGroupe(nom) {
        var retour;
        $.ajaxSetup({async: false});
        $.post("<?php echo url_for('controlNomGroupe') ?>", {'name': nom},
        function (data)
        {
            if (data == "") {
                setHasSuccess("#sf_guard_group_name");
                retour = true;
            }
            else {
                setHasError("#sf_guard_group_name");
                controleNomGroupeTip();
                retour = false;
            }
        });
        return retour;
    }

    function controlCreerGroupe() {
        var erreur = false;
        if ($('#sf_guard_group_name').val() == "") {
            setHasError("#sf_guard_group_name");
            erreur = true;
        }
        if ($('#sf_guard_group_description').val() == "") {
            setHasError("#sf_guard_group_description");
            erreur = true;
        }
        if (erreurGroupe) {
            erreur = true;
        }
        if (erreurDescription) {
            erreur = true;
        }
        if (!erreur) {
            if (controlNomGroupe($('#sf_guard_group_name').val())) {
                $('#sf_guard_group_permissions_list option').prop('selected', 'selected');
                 $('#sf_guard_group_widget_list option').prop('selected', 'selected');
                $('#formNouveauG').submit();
            }
        }
    }

    function controleNomGroupeTip() {
        $('#sf_guard_group_name').qtip({
            position: {
                corner: {
                    target: 'topRight',
                    tooltip: 'bottomLeft'
                }
            },
            content: 'Ce nom de groupe existe déjà !',
            show: {
                ready: true,
                when: {event: false}
            },
            hide: {when: {event: 'click'}},
            style: {
                name: 'dark',
                tip: true
            }
        });
    }



</script>